<?php

namespace App\Repositories;

use App\Interfaces\BookingRepositoryInterface;
use App\Models\Booking;
use App\Models\Product;
use Carbon\Carbon;
use App\Models\ProductBooking;
use Illuminate\Support\Facades\Auth;



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

    // Use $this->generateBookId() for booking id

    public function getAll($search, $page)
    {
        $model = Booking::with($this->relations);

        if ($search === null) {
            $query = $model->orderBy('updated_at', 'desc');
            return $query->paginate($page);
        } else {
            $query = $model
                ->whereHas('users', function ($query) use ($search) {
                    $query->where('email', 'like', '%' . $search . '%');
                })
                ->orWhere('book_id', 'like', '%' . $search . '%')
                ->orderBy('updated_at', 'desc');
            return $query->paginate($page);
        }
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
        $userId = Auth::id();
        $bookId = $this->generateBookId();
        $totalPrice = 0;

        $booking = Booking::create([
            'user_id' => $userId,
            'book_id' => $bookId,
            'total_price' => $totalPrice,
            'booking_date' => Carbon::createFromFormat('Y-m-d', $dataDetails['booking_date'])->format('Y-m-d'),
            'booking_time' =>  $dataDetails['booking_time']
        ]);

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
}
