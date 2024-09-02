<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUIDAsPrimaryKey;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Invoice extends Model
{
    use HasFactory, UUIDAsPrimaryKey;
    protected $table = 'invoices';


    protected $fillable = [
        'invoice_id',
        'user_id',
        'book_id',
        'amount',
        'payment_link',
        'status',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'book_id', 'book_id');
    }

    public function getQris()
    {
        $qris = url($this->payment_link);
        return $qris;
    }
}
