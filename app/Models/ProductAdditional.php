<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUIDAsPrimaryKey;

class ProductAdditional extends Model
{
    use HasFactory, UUIDAsPrimaryKey;

    protected $table = 'products_additional';

    protected $fillable = [
        'name',
        'price',
        'price_text',
        'picture',
        'status',
    ];

    public function getPicProductAdditional()
    {
        if ($this->picture === null) {
            return asset('template/assets/img/elements/12.jpg');
        } else {
            return url('images/picture/products-additional/'.$this->picture);
        }
    }
}
