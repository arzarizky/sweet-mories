<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUIDAsPrimaryKey;
use Illuminate\Database\Eloquent\Relations\HasMany;


class PivotUserProductBooking extends Model
{
    use HasFactory, UUIDAsPrimaryKey;
    protected $table = 'pivot_users_products_bookings';

    public function userBook(): HasMany
    {
        return $this->hasMany(User::class, 'user_id', 'id');
    }

    public function productDetail(): HasMany
    {
        return $this->hasMany(Product::class, 'products_id', 'id');
    }

    public function bookingDetail(): HasMany
    {
        return $this->hasMany(Booking::class, 'book_id', 'book_id');
    }
}
