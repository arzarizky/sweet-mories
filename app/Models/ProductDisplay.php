<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUIDAsPrimaryKey;

class ProductDisplay extends Model
{
    use HasFactory, UUIDAsPrimaryKey;

    protected $table = 'products_display';

    protected $fillable = [
        'name',
        'product_id',
        'product_background_id',
        'product_additional_id',
    ];

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function productsBackground()
    {
        return $this->belongsTo(ProductBackground::class, 'product_background_id', 'id');
    }

    public function productsAdditional()
    {
        return $this->belongsTo(ProductAdditional::class, 'product_additional_id', 'id');
    }


}
