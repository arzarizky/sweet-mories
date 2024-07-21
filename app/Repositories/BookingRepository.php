<?php

namespace App\Repositories;

use App\Interfaces\BookingRepositoryInterface;
use App\Models\Booking;
use App\Models\User;
use App\Models\Product;
use App\Models\PivotUserProductBooking;
use Illuminate\Support\Facades\Auth;



class BookingRepository implements BookingRepositoryInterface
{
    protected $relations = [
        'userBook',
        'productDetail',
        'bookingDetail'
    ];

    private static function generateBookId()
    {
        $prefix = 'BOOK-';
        $timestamp = now()->format('YmdHis');
        $randomNumber = mt_rand(1000, 9999);
        return $prefix . $timestamp . '-' . $randomNumber;
    }

    // Use $this->generateBookId() for booking id

    public function getAll($search, $page)
    {
        $model = PivotUserProductBooking::with($this->relations);

        if ($search === null) {
            $query = $model->orderBy('updated_at','desc');
            return $query->paginate($page);
        } else {
            $query = $model
            ->whereHas('userBook', function ($query) use($search){
                $query->where('email', 'like', '%'.$search.'%');
            })
            ->orWhere('book_id', 'like', '%'.$search.'%')
            ->orderBy('updated_at','desc');
            return $query->paginate($page);
        }
    }


    public function getById($dataId)
    {
        return PivotUserProductBooking::where('book_id', $dataId)->get();
    }

    public function create($dataDetails)
    {
        $bookId = $this->generateBookId();
        $totalPrice = 0;

        foreach ($dataDetails['items'] as $item) {
            $product = Product::where('name', $item['product_name'])->firstOrFail();
            $totalPrice += $product->price * $item['quantity'];
            PivotUserProductBooking::create([
                'user_id' => Auth::id(),
                'book_id' => $bookId,
                'products_id' => $product->id,
                'quantity_product' => $item['quantity'],
            ]);
        }

        Booking::create([
            'book_id' => $bookId,
            'total_price' => $totalPrice,
            'booking_date' => $dataDetails['booking_date'],
            'booking_time' => $dataDetails['booking_time'],
        ]);
    }

    public function updateStatusBook($dataId, $newDetailsData)
    {
        $id = Booking::findOrFail($dataId);
        $id->update($newDetailsData);
    }
}
