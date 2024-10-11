<?php

namespace App\Repositories;

use App\Interfaces\BookingRepositoryInterface;
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

class BookingRepository implements BookingRepositoryInterface
{
    protected $relations = [
        'users',
        'invoice',
        'productBookings.products',
        'productAdditionalBookings.productsAdditional',
        'productBackgroundBookings.productsBackground'
    ];

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
                'alias_name_booking' => $dataDetails['alias_name_booking'],
                'total_price' => 0, // Updated later
                'booking_date' => $dataDetails['booking_date'],
                'booking_time' => $dataDetails['booking_time'],
                'expired_at' => now()->addMinutes(6)
            ]);

            $totalPrice = 0;

            // Process main product
            if (!empty($dataDetails['main_product'])) {
                $mainProduct = Product::where('name', $dataDetails['main_product']['product_name'])->first();

                if ($mainProduct) {
                    $quantity = $dataDetails['main_product']['quantity'];
                    $price = $mainProduct->promo === "true" ? $mainProduct->price_promo : $mainProduct->price;
                    $totalPrice += $price * $quantity;

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

            DB::commit();

            return [
                "sukses" => true,
                "pesan" => "Booking " . $user->email . " pada tanggal " . $dataDetails['booking_date'] . " pukul " . $dataDetails['booking_time'] . " berhasil di booking"
            ];

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

    public function getAll($search, $page, $date)
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

        $query = $model;

        // Filter by email and book id (if provided)
        if ($search) {
            $query = $query->whereHas('users', function ($query) use ($search) {
                $query->where('email', 'like', '%' . $search . '%');
            })->orWhere('book_id', 'like', '%' . $search . '%');
        }

        // Filter by booking_date (if provided)
        if ($date) {
            $query = $query->where('booking_date', $date);
        }

        // Order the results by updated_at in descending order
        $query = $query->orderBy('booking_time', 'asc');

        // Paginate the results
        return $query->paginate($page);
    }

    public function getClient($search, $page)
    {
        $model = Booking::with([
            'users',
            'invoice',

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
