<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\UUIDAsPrimaryKey;

class ProductBooking extends Model
{
    use HasFactory, UUIDAsPrimaryKey;

    protected $table = 'products_bookings';

    public function productDetail(): HasMany
    {
        return $this->hasMany(Product::class, 'id', 'products_id');
    }
}
