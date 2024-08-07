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


        if ($payload['transaction_status'] = "settlement") {
            Invoice::where('invoice_id', $payload['order_id'])->where('status', 'PENDING')->update([
                'status' => 'PAID',
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
