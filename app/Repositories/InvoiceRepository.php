<?php

namespace App\Repositories;

use App\Interfaces\InvoiceRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;
use App\Models\Booking;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    protected $relations = [
        'users',
        'bookings',
    ];

    public function getAll($search, $page)
    {
        $model = Invoice::with($this->relations);

        if ($search === null) {
            $query = $model->orderBy('updated_at','desc');
            return $query->paginate($page);
        } else {
            $query = $model
            ->whereHas('users', function ($query) use($search){
                $query->where('email', 'like', '%'.$search.'%');
            })
            ->orWhere('invoice_id', 'like', '%'.$search.'%')
            ->orderBy('updated_at','desc');
            return $query->paginate($page);
        }
    }

    public function getById($dataId)
    {
        return Invoice::where('invoice_id', $dataId)->get();
    }

    public function getByIdBooking($dataId)
    {
        return Invoice::where('book_id', $dataId)->get();
    }


    public function getClient($search, $perPage)
    {
        $model = Invoice::with($this->relations);

        if ($search === null) {
            $query = $model
                ->where('user_id', 'like', '%' . Auth::user()->id . '%')
                ->orderBy('updated_at', 'desc');
            return $query->paginate($perPage);
        } else {
            $query = $model
                ->where('user_id', 'like', '%' . Auth::user()->id . '%')
                ->where('book_id', 'like', '%' . $search . '%')
                ->orderBy('updated_at', 'desc');
            return $query->paginate($perPage);
        }
    }

    // Use $this->generateInvoiceId() for invoice id
    private static function generateInvoiceId()
    {
        $prefix = 'INV-';
        $timestamp = now()->format('dmYHis');
        $randomNumber = mt_rand(1000, 9999);
        return $prefix . $randomNumber . '-' . $timestamp;
    }

    // Use $this->validatorBook($userId, $bookId) for check booking user
    private static function validatorBook($userId, $bookId)
    {
        $bookQuery = Booking::where('user_id', $userId)->where('book_id',  $bookId);
        $statusBook = $bookQuery->first('status');
        $priceBook = $bookQuery->first('total_price');

         if (!$statusBook) {
            return [
                'success' => false,
                'message' => 'Booking not found or user does not have access.',
            ];
         }

         if ($statusBook->status === 'DONE') {
             return[
                'success' => false,
                'message' => 'Booking is already DONE.',
             ];

         } elseif ($statusBook->status === 'ON PROCESS') {
             return[
                'success' => false,
                'message' => 'Booking is ON PROCESS.',
             ];

         } elseif ($statusBook->status === 'PENDING') {
            return[
                'success' => true,
                'message' => 'Book Valid',
                'price_book' => $priceBook->total_price
            ];

        } else {
            return[
                'success' => false,
                'message' => 'Booking status not definition or user does not have access.',
            ];
        }
    }

    public function create($dataDetails)
    {

        $userId = Auth::id();
        $bookId = $dataDetails['book_id'];
        $validatorBook = $this->validatorBook($userId, $bookId);

        if ($validatorBook['success'] === false) {

            return [
                'success' => $validatorBook['success'],
                'message' => $validatorBook['message'],
            ];

        } else {

            $invId = $this->generateInvoiceId();
            $Invc = Invoice::create([
                'invoice_id'    => $invId,
                'user_id'       => $userId,
                'book_id'       => $bookId,
                'amount'        => $validatorBook['price_book'],
                'payment_due_at' => now()->addMinutes(6),
            ]);

            Booking::where('book_id', $bookId)->update(['status' => "PAYMENT PROCESS"]);

            $payment = $this->createPayment($invId);
            $parsing = json_decode($payment, true);
            Invoice::where('invoice_id',$invId)->update([
                'payment_link'  => $parsing['actions'][0]['url'],
            ]);

            return [
                'success'       => $validatorBook['success'],
                'invoice_id'    => $invId,
                'user_id'       => $userId,
                'book_id'       => $bookId,
                'amount'        => $validatorBook['price_book'],
                'message'       => $validatorBook['message'],
                'qr_string'     => $payment,
            ];
        }
    }

    public function createPayment($invId)
    {
        $curl = curl_init();

        $Invoice = Invoice::where('invoice_id', $invId)->where('status','PENDING')->first();

        $payload = [
            "payment_type" => "qris",
            "transaction_details" => [
                "order_id" => $invId,
                "gross_amount" => $Invoice->amount,
            ],
            "qris" => [
                "acquirer" => "airpay shopee"
            ]
        ];

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.sandbox.midtrans.com/v2/charge',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic U0ItTWlkLXNlcnZlci14a2MtOHpoS193YnUxSW1zSVBJV2JyTUs6',
                'Content-Type: application/json'
            ),
        ));

        //DEV Basic U0ItTWlkLXNlcnZlci14a2MtOHpoS193YnUxSW1zSVBJV2JyTUs6
        //DEV https://api.sandbox.midtrans.com

        //PROD Basic TWlkLXNlcnZlci1ZS2o4RlRuRjRORl9aeG5PTllPNWUwclc6
        //PROD https://api.midtrans.com

        $response = curl_exec($curl);

        curl_close($curl);


        return $response;
    }

}

