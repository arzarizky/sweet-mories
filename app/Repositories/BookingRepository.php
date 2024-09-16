<?php

namespace App\Repositories;

use App\Interfaces\BookingRepositoryInterface;
use App\Models\Booking;
use App\Models\Product;
use Carbon\Carbon;
use App\Models\ProductBooking;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class BookingRepository implements BookingRepositoryInterface
{
    protected $relations = [
        'users',
        'productBookings.products'
    ];

    private static function generateBookId()
    {
        $prefix = 'BOOK-';
        $timestamp = now()->format('dmYHis');
        $randomNumber = mt_rand(1000, 9999);
        return $prefix . $randomNumber . '-' . $timestamp;
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

    public function create($dataDetails)
    {
        $noTlp = "+62" . $dataDetails['no_tlp'];
        $userId = Auth::id();
        $bookId = $this->generateBookId();
        $totalPrice = 0;

        $booking = Booking::create([
            'user_id' => $userId,
            'book_id' => $bookId,
            'total_price' => $totalPrice,
            'booking_date' => Carbon::createFromFormat('Y-m-d', $dataDetails['booking_date'])->format('Y-m-d'),
            'booking_time' =>  $dataDetails['booking_time'],
            'expired_at' => now()->addMinutes(6)
        ]);

        $userTlp = User::find(Auth::id());

        if ($userTlp->no_tlp === null) {
            User::where('id', Auth::id())->update([
                'no_tlp' => $noTlp,
            ]);
        }

        foreach ($dataDetails['items'] as $item) {
            $product = Product::where('name', $item['product_name'])->firstOrFail();
            $totalPrice += $product->price * $item['quantity'];
            ProductBooking::create([
                'book_id' => $bookId,
                'product_id' => $product->id,
                'quantity_product' => $item['quantity'],
            ]);
        }

        Booking::where('book_id', $booking->book_id)->update(['total_price' => $totalPrice]);

        return [
            "sukses" => true,
            "pesan" => "Booking " . Auth::user()->email . " pada tanggal " . $dataDetails['booking_date'] . " pukul " .  $dataDetails['booking_time'] . " berhasil di booking"
        ];
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
}
