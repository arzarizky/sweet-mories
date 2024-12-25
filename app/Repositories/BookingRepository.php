<?php

namespace App\Repositories;

use App\Interfaces\BookingRepositoryInterface;
use App\Interfaces\InvoiceRepositoryInterface;
use App\Models\Booking;
use App\Models\Product;
use Carbon\Carbon;
use App\Models\ProductBooking;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\ProductAdditional;
use App\Models\ProductBackground;
use App\Models\ProductDisplay;
use App\Repositories\PromoRepository;
use App\Models\Promo;

class BookingRepository implements BookingRepositoryInterface
{
    protected $relations = [
        'users',
        'invoice',
        'promo',
        'productBookings.products',
        'productAdditionalBookings.productsAdditional',
        'productBackgroundBookings.productsBackground'
    ];

    protected $promoRepository;
    protected $invoiceRepository;

    public function __construct(InvoiceRepositoryInterface $invoiceRepository, PromoRepository $promoRepository)
    {
        $this->promoRepository = $promoRepository;
        $this->invoiceRepository = $invoiceRepository;
    }

    private static function generateBookId()
    {
        $prefix = 'BOOK-';
        $timestamp = now()->format('dmYHis');
        $randomNumber = mt_rand(1000, 9999);
        return $prefix . $randomNumber . '-' . $timestamp;
    }

    public function canBook($bookingDate, $bookingTime)
    {
        // Gunakan locking untuk mencegah race condition
        return DB::table('bookings')
            ->where('booking_date', $bookingDate)
            ->where('booking_time', $bookingTime)
            ->where('status', '!=', 'EXP')  // Exclude statuses that are considered non-active
            ->lockForUpdate()  // Gunakan locking untuk mencegah race condition
            ->doesntExist();
    }

    public function SendDataToPG($dataDetails, $totalPrice, $bookId, $discount, $promoCode)
    {
        $mainProduct = Product::where('id', $dataDetails['id_product'])->first();

        if ($mainProduct->promo == true) {
            $price = $mainProduct->price_promo;
            $productName = $mainProduct->name . " " . $mainProduct->type . " Promo";
        } else {
            $price = $mainProduct->price;
            $productName = $mainProduct->name . " " . $mainProduct->type;
        }

        $mainProductData = [
            "type_product" => "Main Product",
            "name" => $productName,
            "price" => (int) $price,
            "quantity" => 1
        ];

        $additionalProductNames = array_column($dataDetails["additional_products"], 'product_name');

        $additionalProducts = ProductAdditional::whereIn('name', $additionalProductNames)->get()->keyBy('name');

        $additionalProductData = [
            "type_product" => "Additional Product",
            "item_list" => array_filter(array_map(function($product) use ($additionalProducts) {
                $product['name'] = $product['product_name'];
                unset($product['product_name']);

                if (isset($additionalProducts[$product['name']])) {
                    $product['price'] = (int) $additionalProducts[$product['name']]->price;
                } else {
                    $product['price'] = 0;
                }

                $product['quantity'] = (int) $product['quantity'];

                if ($product['quantity'] > 0) {
                    return $product;
                }

                return null;
            }, $dataDetails["additional_products"])),
        ];



        if (!empty($dataDetails['background'])) {
            $background = "Background ". $dataDetails['background'];
        } else {
            $background = "Background Projector";
        }

        $ProductBackgroundData = [
            "type_product" => "Product Background",
            "name" => $background,
            "price" => 0,
            "quantity" => 1
        ];

        $promo = [
            "name" => "Discount dengan kode promo " . $promoCode,
            "price" => (int) $discount * -1,
            "quantity" => 1
        ];

        return [
            "book_id" => $bookId,
            "main_product" => $mainProductData,
            "additional_product" => $additionalProductData,
            "product_background" => $ProductBackgroundData,
            "promo" => $promo
        ];

    }


    public function create($dataDetails)
    {
        DB::beginTransaction();

        try {

            // Check if the booking slot is available
            if (!$this->canBook($dataDetails['booking_date'], $dataDetails['booking_time'])) {
                return [
                    "sukses" => false,
                    "pesan" => "The selected date and time are already booked"
                ];
            }

            $dataDetails['kode_promo'] = $dataDetails['kode_promo'] ?? null;

            if ($dataDetails['kode_promo'] != null) {
                $promo = $this->promoRepository->checkPromo($dataDetails['kode_promo']);
                if($promo['valid'] === true) {
                    $dataDetails['kode_promo'] = $promo['id_promo'];
                    $kodePromo = $promo;
                } else {
                    return [
                        "sukses" => false,
                        "pesan" => "Promo Tidak Valid"
                    ];
                }
            } else {
                $dataDetails['kode_promo'] = $dataDetails['kode_promo'];
            }

            $user = Auth::user();
            $dataDetails['background_qty'] = "1";

            // Update user phone number if not set
            if (is_null($user->no_tlp)) {
                $user->update(['no_tlp' => "+62" . $dataDetails['no_tlp']]);
            }

            // Generate unique booking ID
            $bookId = $this->generateBookId();

            // Create booking entry
            $booking = Booking::create([
                'user_id' => $user->id,
                'book_id' => $bookId,
                'promo_id' => $dataDetails['kode_promo'],
                'alias_name_booking' => $dataDetails['alias_name_booking'],
                'total_price' => 0, // Updated later
                'booking_date' => $dataDetails['booking_date'],
                'booking_time' => $dataDetails['booking_time'],
            ]);

            $totalPrice = 0;
            $discount = null;
            $promoCode = null;

            // Process main product
            if (!empty($dataDetails['main_product'])) {
                $mainProduct = Product::where('id', $dataDetails['main_product']['product_name'])->first();

                if ($mainProduct) {
                    $quantity = $dataDetails['main_product']['quantity'];
                    $price = $mainProduct->promo === "true" ? $mainProduct->price_promo : $mainProduct->price;

                    if($mainProduct->promo === "false") {
                        if ($dataDetails['kode_promo'] != null) {
                            $usagePromo =  Promo::where('id', $dataDetails['kode_promo'])->first();
                            $promoCode = $usagePromo->code;
                            if ($usagePromo->model === "NUMBER") {
                                $kodePromoPrice = $price - $usagePromo->discount_value;
                                $discount = (int) $usagePromo->discount_value;
                                $totalPrice += $kodePromoPrice * $quantity;
                                $updateUsagePromo = $usagePromo->used_count + 1;
                                $usagePromo->used_count=$updateUsagePromo;
                                $usagePromo->save();
                            } else {
                                $kodePromoPrice = $price * $usagePromo->discount_percentage / 100;
                                $discount = (int) $kodePromoPrice;
                                $totalPrice += $price - $kodePromoPrice * $quantity;
                                $updateUsagePromo = $usagePromo->used_count + 1;
                                $usagePromo->used_count=$updateUsagePromo;
                                $usagePromo->save();
                            }
                        } else {
                            $totalPrice += $price * $quantity;
                        }
                    } else {
                        $totalPrice += $price * $quantity;
                    }

                    // Store main product in ProductBooking table
                    ProductBooking::create([
                        'book_id' => $bookId,
                        'product_id' => $mainProduct->id,
                        'quantity_product' => $quantity,
                    ]);
                } else {
                    \Log::warning("Main product not found", ['product_name' => $dataDetails['main_product']['product_name']]);
                    return [
                        "sukses" => false,
                        "pesan" => "Product not found: " . $dataDetails['main_product']['product_name']
                    ];
                }
            }

            // Process background product
            if (!empty($dataDetails['background'])) {
                $backgroundProduct = ProductBackground::where('name', $dataDetails['background'])->first();
                if ($backgroundProduct) {
                    // Store background product in ProductBooking table
                    ProductBooking::create([
                        'book_id' => $bookId,
                        'background_product_id' => $backgroundProduct->id,
                        'quantity_product' => $dataDetails['background_qty'],
                    ]);
                } else {
                    \Log::warning("Background product not found", ['background_name' => $dataDetails['background']]);
                    return [
                        "sukses" => false,
                        "pesan" => "Background product not found: " . $dataDetails['background']
                    ];
                }
            }

            // Process additional products in a batch
            if (!empty($dataDetails['additional_products'])) {
                $additionalProductNames = array_column($dataDetails['additional_products'], 'product_name');
                $additionalProducts = ProductAdditional::whereIn('name', $additionalProductNames)->get()->keyBy('name');

                foreach ($dataDetails['additional_products'] as $additional) {
                    $productAdditional = $additionalProducts->get($additional['product_name']);

                    if ($productAdditional) {
                        $quantity = $additional['quantity'];
                        $totalPrice += $productAdditional->price * $quantity;

                        // Store additional product in ProductBooking table
                        ProductBooking::create([
                            'book_id' => $bookId,
                            'additional_product_id' => $productAdditional->id,
                            'quantity_product' => $quantity,
                        ]);
                    } else {

                        \Log::warning("Additional product not found", ['additional_product_name' => $additional['product_name']]);
                        return [
                            "sukses" => false,
                            "pesan" => "Additional product not found: " . $additional['product_name']
                        ];
                    }
                }
            }

            // Update total price for the booking
            $booking->update(['total_price' => $totalPrice]);

            $dataToPG = $this->SendDataToPG($dataDetails, $totalPrice, $bookId, $discount, $promoCode,);

            DB::commit();

            $paymentCreate = $this->invoiceRepository->create($dataToPG);

            if ($paymentCreate['success'] === true) {
                return [
                    "sukses" => true,
                    "pesan" => $paymentCreate['payment_link']
                ];

            } else {
                return [
                    "sukses" => false,
                    "pesan" => $paymentCreate['success']
                ];
            }

        } catch (\Exception $e) {
            DB::rollBack();

            // Log the exception message for debugging
            \Log::error("Error during booking creation: " . $e->getMessage(), [
                'dataDetails' => $dataDetails,
                'user_id' => $user->id ?? null,
            ]);

            return [
                "sukses" => false,
                "pesan" => "Additional product not found: " . $e->getMessage()
            ];
        }
    }


    public function updateStatusBook($dataId, $newDetailsData)
    {
        Booking::where('id', $dataId)->update(['status' => $newDetailsData['status']]);
    }

    public function reschedule($dataId)
    {
        $model = Booking::with([
            'users',
            'invoice',

            // Filter 'productBookings' where 'product_id' is not null
            'productBookings' => function ($query) {
                $query->whereNotNull('product_id');
            },
            'productBookings.products',

            // Filter 'productAdditionalBookings' where 'additional_product_id' is not null
            'productAdditionalBookings' => function ($query) {
                $query->whereNotNull('additional_product_id');
            },
            'productAdditionalBookings.productsAdditional', // Eager load productsAdditional

            // Filter 'productBackgroundBookings' where 'background_product_id' is not null
            'productBackgroundBookings' => function ($query) {
                $query->whereNotNull('background_product_id');
            },
            'productBackgroundBookings.productsBackground'
        ]);

        $query = $model->where('id', $dataId)->first();
        return $query;
    }

    public function UpdateReschedule($dataId, $newDetailsData)
    {
        Booking::where('id', $dataId)->update(
            [
                'booking_date' => $newDetailsData['booking_date'],
                'booking_time' => $newDetailsData['booking_time']
            ]
        );

        return [
            'date' => $newDetailsData['booking_date'],
            'time' => $newDetailsData['booking_time']
        ];
    }

    public function getAll($search = null, $page = 15, $date = null, $status = null)
    {
        $query = Booking::with([
            'users',
            'invoice',
            'promo',
            'productBookings' => fn($q) => $q->whereNotNull('product_id')->with('products'),
            'productAdditionalBookings' => fn($q) => $q->whereNotNull('additional_product_id')->with('productsAdditional'),
            'productBackgroundBookings' => fn($q) => $q->whereNotNull('background_product_id')->with('productsBackground'),
        ]);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('users', fn($q) => $q->where('email', 'like', '%' . $search . '%'))
                ->orWhere('book_id', 'like', '%' . $search . '%');
            });
        }

        if ($date) {
            $query->where('booking_date', $date);
        }

        if ($status && $status !== 'ALL') {
            $query->where('status', $status);
        }

        $query->orderBy('booking_time', 'asc');

        return $query->paginate($page);
    }


    public function getClient($search, $page)
    {
        $model = Booking::with([
            'users',
            'invoice',
            'promo',

            'productBookings' => function ($query) {
                $query->whereNotNull('product_id');
            },
            'productBookings.products',

            'productAdditionalBookings' => function ($query) {
                $query->whereNotNull('additional_product_id');
            },
            'productAdditionalBookings.productsAdditional', // Eager load productsAdditional

            'productBackgroundBookings' => function ($query) {
                $query->whereNotNull('background_product_id');
            },
            'productBackgroundBookings.productsBackground'
        ]);

        if ($search === null) {
            $query = $model
                ->where('user_id', 'like', '%' . Auth::user()->id . '%')
                ->orderBy('updated_at', 'desc');
            return $query->paginate($page);
        } else {
            $query = $model
                ->where('user_id', 'like', '%' . Auth::user()->id . '%')
                ->where('book_id', 'like', '%' . $search . '%')
                ->orderBy('updated_at', 'desc');
            return $query->paginate($page);
        }
    }


    public function getById($dataId)
    {
        return Booking::where('book_id', $dataId)->get();
    }
}
