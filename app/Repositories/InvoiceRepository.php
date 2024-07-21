<?php

namespace App\Repositories;

use App\Interfaces\InvoiceRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;
use App\Models\Booking;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    protected $relations = [
        'userbook',
        'bookingDetail',
    ];

    public function getAll($search, $page)
    {
        $model = Invoice::with($this->relations);

        if ($search === null) {
            $query = $model->orderBy('updated_at','desc');
            return $query->paginate($page);
        } else {
            $query = $model
            ->whereHas('userBook', function ($query) use($search){
                $query->where('email', 'like', '%'.$search.'%');
            })
            ->orWhere('book_id', 'like', '%'.$search.'%')
            ->orWhere('invoice_id', 'like', '%'.$search.'%')
            ->orderBy('updated_at','desc');
            return $query->paginate($page);
        }

    }

    public function getById($dataId)
    {
        return Invoice::where('invoice_id', $dataId)->get();
    }

    // Use $this->generateInvoiceId() for invoice id
    private static function generateInvoiceId()
    {
        $prefix = 'INV-';
        $timestamp = now()->format('YmdHis');
        $randomNumber = mt_rand(1000, 9999);
        return $prefix . $timestamp . '-' . $randomNumber;
    }

    // Use $this->validatorBook($userId, $bookId) for check booking user
    private static function validatorBook($userId, $bookId)
    {
        // Cari status booking berdasarkan user_id dan booking_id
        $bookQuery = Booking::where('user_id', $userId)->where('book_id',  $bookId);
        $statusBook = $bookQuery->first('status');
        $priceBook = $bookQuery->first('total_price');

        // Jika tidak ditemukan status booking
        if (!$statusBook) {
            return [
                'success' => false,
                'message' => 'Booking not found or user does not have access.',
            ];
        }

        // Jika status booking adalah 'DONE'
        if ($statusBook->status === 'DONE') {
            return[
                'success' => false,
                'message' => 'Booking is already DONE.',
            ];

        // Jika status booking adalah 'ON PROCESS'
        } elseif ($statusBook->status === 'ON PROCESS') {
            return[
                'success' => false,
                'message' => 'Booking is ON PROCESS.',
            ];

        // Jika status booking adalah 'PENDING'
        } elseif ($statusBook->status === 'PENDING') {
            return[
                'success' => true,
                'message' => 'Book Valid',
                'price_book' => $priceBook
            ];

        // Jika tidak ada yang sesuai definisi table booking
        } else {
            return[
                'success' => false,
                'message' => 'Booking status not definition or user does not have access.',
            ];
        }
    }

    public function create($dataDetails)
    {
        $UserId = Auth::id();
        $bookId = $dataDetails['book_id'];
        $validatorBook = $this->validatorBook($userId, $bookId);

        if ($validatorBook['success'] === false) {
            # code...
        } else {
           // ISIKAN MAI
        }
    }
}
