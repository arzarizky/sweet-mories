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
        'status',
        'product_id',
        'product_background',
        'product_additional_id',
    ];

    protected $casts = [
        'product_additional_id' => 'array',
    ];

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function getProductAdditionals()
    {
        $additionalIds = json_decode($this->product_additional_id , true);

        if (is_null($additionalIds) || empty($additionalIds)) {
            return collect();
        }

        return ProductAdditional::whereIn('id', $additionalIds)->get();
    }

    public function getProductBackground()
    {
        $typeBackground = $this->product_background;

        if (is_null($typeBackground) || empty($typeBackground)) {
            return collect();
        }

        return ProductBackground::where('type', $typeBackground)->where('status', 'ENABLE')->get();
    }

    public function getPicProduct($picture)
    {
        $pictureProduct = Product::where('picture', $picture)->first();

        if ($pictureProduct->picture === null) {
            return asset('template/assets/img/elements/12.jpg');
        } else {
            return url('images/picture/products-main/'.$picture);
        }
    }
}
