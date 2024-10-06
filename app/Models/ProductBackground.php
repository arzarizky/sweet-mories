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
        'picture',
        'type',
        'status'
    ];

    public function productDisplay()
    {
        return $this->hasMany(ProductDisplay::class, 'id', 'product_background_id');
    }

    public function getPicProductBackground()
    {
        if ($this->picture === null) {
            return asset('template/assets/img/elements/12.jpg');
        } else {
            return url('images/picture/products-background/'.$this->picture);
        }
    }
}
