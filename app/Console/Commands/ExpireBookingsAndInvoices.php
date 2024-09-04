<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Models\Invoice;

class ExpireBookingsAndInvoices extends Command
{
    protected $signature = 'bookingsInvoices:expire';

    protected $description = 'Expire bookings and invoices that have not been paid within the allowed time';

    public function handle()
    {
        $now = now();

        // Book Pending

        $expiredBookings = Booking::where('status', 'PENDING')
            ->where('expired_at', '<=', $now)
            ->get();

        foreach ($expiredBookings as $booking) {
            $booking->status = 'EXP';
            $booking->save();
        }

        // Book PAYMENT PROCESS
        $expiredBookings = Booking::where('status', 'PAYMENT PROCESS')
            ->where('expired_at', '<=', $now)
            ->get();

        foreach ($expiredBookings as $booking) {
            $booking->status = 'EXP';
            $booking->save();
        }


        // PAYMENT PENDING
        $expiredInvoices = Invoice::where('status', 'PENDING')
            ->where('payment_due_at', '<=', $now)
            ->get();

        foreach ($expiredInvoices as $invoice) {
            $invoice->status = 'EXP';
            $invoice->save();
        }

        $this->info('Expired bookings and invoices updated successfully.');
    }
}
