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

class BookingRepository implements BookingRepositoryInterface
{
    protected $relations = [
        'users',
        'invoice',
        'productBookings.products'
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

            // Gunakan locking untuk mencegah double booking
            if (!$this->canBook($dataDetails['booking_date'], $dataDetails['booking_time'])) {
                return [
                    "sukses" => false,
                    "pesan" => "The selected date and time are already booked"
                ];
            }

            // Proses booking dan update nomor telepon user
            $user = Auth::user();
            $noTlp = "+62" . $dataDetails['no_tlp'];

            // Perbarui nomor telepon jika null
            if (is_null($user->no_tlp)) {
                $user->update(['no_tlp' => $noTlp]);
            }

            // Generate booking ID dan kalkulasi total harga
            $bookId = $this->generateBookId();
            $totalPrice = 0;

            // dd($dataDetails)

            // Buat booking
            $booking = Booking::create([
                'user_id' => $user->id,
                'book_id' => $bookId,
                'alias_name_booking' => $dataDetails['alias_name_booking'],
                'total_price' => $totalPrice,
                'booking_date' => $dataDetails['booking_date'],
                'booking_time' => $dataDetails['booking_time'],
                'expired_at' => now()->addMinutes(6)
            ]);

            // Menggunakan eager loading untuk produk booking
            $products = Product::whereIn('name', array_column($dataDetails['items'], 'product_name'))->get()->keyBy('name');

            foreach ($dataDetails['items'] as $item) {
                $product = $products->get($item['product_name']);
                if ($product) {
                    $totalPrice += $product->price * $item['quantity'];

                    // Insert ke tabel pivot product_booking
                    ProductBooking::create([
                        'book_id' => $bookId,
                        'product_id' => $product->id,
                        'quantity_product' => $item['quantity'],
                    ]);
                }
            }

            // Update total price
            $booking->update(['total_price' => $totalPrice]);

            DB::commit();  // Commit jika semua berhasil

            return [
                "sukses" => true,
                "pesan" => "Booking " . $user->email . " pada tanggal " . $dataDetails['booking_date'] . " pukul " . $dataDetails['booking_time'] . " berhasil di booking"
            ];

        } catch (\Exception $e) {
            DB::rollBack();  // Rollback jika terjadi error

            return [
                "sukses" => false,
                "pesan" => "Terjadi kesalahan saat melakukan booking, silakan coba lagi."
            ];
        }
    }

    public function updateStatusBook($dataId, $newDetailsData)
    {
        Booking::where('id', $dataId)->update(['status' => $newDetailsData['status']]);
    }

    public function reschedule($dataId)
    {
        $model = Booking::with($this->relations);
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
        $model = Booking::with($this->relations);

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
        $model = Booking::with($this->relations);

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
