<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUIDAsPrimaryKey;

class ProductBackground extends Model
{
    use HasFactory, UUIDAsPrimaryKey;

    protected $table = 'products_background';

    protected $fillable = [
        'name',
        'price',
        'picture'
    ];

    public function productDisplay()
    {
        return $this->hasMany(ProductDisplay::class, 'id', 'product_background_id');
    }
}
