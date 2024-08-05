<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\PaymentHistory;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createPayment(Request $request)
    {
        $curl = curl_init();

        $book = Booking::where('book_id', $request->order_id)->where('status', 'PENDING')->first();

        // dd($book);
        $payload = [
            "payment_type" => "qris",
            "transaction_details" => [
                "order_id" => $request->order_id,
                "gross_amount" => $book->total_price,
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

        $response = curl_exec($curl);

        curl_close($curl);

        Booking::where('book_id', $request->order_id)->where('status', 'PENDING')->update([
            'payment_link' => json_encode($response),
            'status' => 'ON PROCESS',
        ]);


        return response()->json([
            'message' => 'Payment link has been created',
            'data' => ['qr_string' => $response['qr_string']],
        ]);
    }

    public function callback(Request $request)
    {
        $payload = $request->all();
        $paymentHistory = new PaymentHistory();
        $paymentHistory->payload = json_encode($payload);
        $paymentHistory->save();


        if ($payload['transaction_status'] = "settlement") {
            Booking::where('book_id', $payload['order_id'])->where('status', 'ON PROCESS')->update([
                'status' => 'DONE',
            ]);
        }

        return response()->json([
            'message' => 'Payment callback has been saved',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
