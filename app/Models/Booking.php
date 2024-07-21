<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\UUIDAsPrimaryKey;


class Booking extends Model
{
    use HasFactory, UUIDAsPrimaryKey;
    protected $table = 'bookings';

    public function userbook(): HasMany
    {
        return $this->hasMany(User::class, 'user_id', 'id');
    }

    public function bookingDetail(): HasMany
    {
        return $this->hasMany(ProductBooking::class, 'book_id', 'book_id');
    }
}
