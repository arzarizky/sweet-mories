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

    protected $fillable = [
        'book_id',
        'product_id',
        'background_product_id',
        'additional_product_id',
        'quantity_product',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'book_id', 'book_id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function productsAdditional()
    {
        return $this->belongsTo(ProductAdditional::class, 'additional_product_id', 'id');
    }

    public function productsBackground()
    {
        return $this->belongsTo(ProductBackground::class, 'background_product_id', 'id');
    }
}
