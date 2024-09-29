<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use App\Models\ProductAdditional;
use App\Models\ProductBackground;
use App\Models\ProductDisplay;


class ProductRepository implements ProductRepositoryInterface
{
    protected $relationsProductDisplay = [
        'products',
        'products_additional',
        'products_background',
    ];

    protected function generateFilename($file)
    {
        $pool1 = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $pool2 = 'ABCDEFGHIJKLMNOOQRSTUVWXYZ1234567890abcdefghijklmnopgrstuvwxyz';
        $random1 = substr(str_shuffle(str_repeat($pool1, 5)), 0, 8);
        $random2 = substr(str_shuffle(str_repeat($pool2, 5)), 0, 8);
        return $random1 . '-' . date('d-m-Y-H-i-s') . '-' . $random2 . '.' . $file->extension();
    }

    public function getAllProduct($search, $page)
    {
        $model = Product::orderBy('updated_at','desc');

        $query = $model;

        // Paginate the results
        return $query->paginate($page);
    }

    public function getAllProductAdditional($search, $page)
    {
        $model = ProductBackground::orderBy('updated_at','desc');

        $query = $model;

        // Paginate the results
        return $query->paginate($page);
    }

    public function getAllProductBackground($search, $page)
    {
        $model = ProductDisplay::orderBy('updated_at','desc');

        $query = $model;

        // Paginate the results
        return $query->paginate($page);
    }

    public function getAllProductDisplay($search, $page)
    {
        $model = ProductDisplay::with($this->relationsProductDisplay);

        $query = $model;

        // Order the results by updated_at in descending order
        $query = $query->orderBy('updated_at','desc');

        // Paginate the results
        return $query->paginate($page);
    }


    public function getById($dataId)
    {
        return ProductDisplay::where('book_id', $dataId)->get();
    }


    public function createProduct($dataDetails)
    {
        $dataDetails['picture'] = $dataDetails['picture'] ?? null;

        $picture = $dataDetails['picture'];

        if ($picture != null) {
            $file = $dataDetails['picture'];
            $filename = $this->generateFilename($file);
            $file->move(public_path('images/picture/products/'), $filename);
            $dataDetails['picture'] = $filename;
        }

        Product::create($dataDetails);
    }

    public function createProductAdditional($dataDetails)
    {
        $dataDetails['picture'] = $dataDetails['picture'] ?? null;

        $picture = $dataDetails['picture'];

        if ($picture != null) {
            $file = $dataDetails['picture'];
            $filename = $this->generateFilename($file);
            $file->move(public_path('images/picture/products-additional/'), $filename);
            $dataDetails['picture'] = $filename;
        }

        ProductAdditional::create($dataDetails);
    }

    public function createProductBackground($dataDetails)
    {
        $dataDetails['picture'] = $dataDetails['picture'] ?? null;

        $picture = $dataDetails['picture'];

        if ($picture != null) {
            $file = $dataDetails['picture'];
            $filename = $this->generateFilename($file);
            $file->move(public_path('images/picture/products-background/'), $filename);
            $dataDetails['picture'] = $filename;
        }

        ProductBackground::create($dataDetails);
    }

    public function createProductDisplay($dataDetails)
    {
        ProductDisplay::create($dataDetails);
    }

}
