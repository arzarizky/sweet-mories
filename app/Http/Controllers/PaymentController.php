<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Invoice;
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

    public function callback(Request $request)
    {
        $payload = $request->all();
        $paymentHistory = new PaymentHistory();
        $paymentHistory->payload = json_encode($payload);
        $paymentHistory->save();


        if ($payload['transaction_status'] == "settlement") {
            Invoice::where('invoice_id', $payload['order_id'])->where('status', 'PENDING')->update([
                'status' => 'PAID',
            ]);

            $invoice = Invoice::where('invoice_id', $payload['order_id'])->first();

            Booking::where('book_id', $invoice->book_id)->update([
                'status' => 'ON PROCESS',
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

// {
//     "acquirer": "airpay shopee",
//     "currency": "IDR",
//     "order_id": "INV-7995-04092024104939",
//     "expiry_time": "2024-09-04 11:04:40",
//     "merchant_id": "G888633309",
//     "status_code": "201",
//     "fraud_status": "accept",
//     "gross_amount": "140000.00",
//     "payment_type": "qris",
//     "reference_id": "QR1725421780306DZH8I6Hejd",
//     "signature_key": "e6c41eed0b3e0052044a60532d5a412b72a8028a719aced65647a748ca598f435d59979afe02cebe00c31a42eb3d3acd322393ddf23dcca9383ef8fdd24cdb5f",
//     "status_message": "midtrans payment notification",
//     "transaction_id": "2f0c8fc5-e48f-496a-be3f-ee1945758985",
//     "transaction_time": "2024-09-04 10:49:40",
//     "transaction_type": "off-us",
//     "transaction_status": "pending"
// }
