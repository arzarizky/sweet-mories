<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUIDAsPrimaryKey;

class Product extends Model
{
    use HasFactory, UUIDAsPrimaryKey;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'sub_title',
        'sub_title_promo',
        'price_text',
        'price_promo_text',
        'price',
        'price_promo',
        'promo',
        'tnc',
        'picture',
        'status',
        'note',
        'type'

    ];

    protected $casts = [
        'tnc' => 'array',
        'price' => 'decimal:2',
        'price_promo' => 'decimal:2',
        'status' => 'string',
    ];

    public function productBookings()
    {
        return $this->belongsTo(ProductBooking::class, 'id', 'products_id');
    }

    public function productDisplay()
    {
        return $this->hasMany(ProductDisplay::class, 'id', 'product_id');
    }

    public function getPicProduct()
    {
        if ($this->picture === null) {
            return asset('template/assets/img/elements/12.jpg');
        } else {
            return url('images/picture/products-main/'.$this->picture);
        }
    }
}
