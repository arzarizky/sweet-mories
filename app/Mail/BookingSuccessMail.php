<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->from('teknisi@dwalaw.co.id', 'SWEET MORIES')
                    ->subject('Booking Berhasil')
                    ->view('emails.booking_success')
                    ->with('data', $this->data);
    }
}

