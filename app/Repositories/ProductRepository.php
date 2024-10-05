<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use App\Models\ProductAdditional;
use App\Models\ProductBackground;
use App\Models\ProductDisplay;
use Illuminate\Support\Facades\File;


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

        if ($search === null) {
            $query = $model;
            return $query->paginate($page);
        } else {
            $query = $model->where('name', 'like', '%'.$search.'%');
            return $query->paginate($page);
        }
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
        try {

            $dataDetails['picture'] = $dataDetails['picture'] ?? null;

            $picture = $dataDetails['picture'];

            $dataDetails['price_promo'] = $dataDetails['price_promo'] ?? null;
            $pricePromo = $dataDetails['price_promo'];

            if ($picture != null) {
                $file = $dataDetails['picture'];
                $filename = $this->generateFilename($file);
                $file->move(public_path('images/picture/products-main/'), $filename);
                $dataDetails['picture'] = $filename;
            }

            if ($pricePromo != null) {
                $dataDetails['promo'] = "true";
            } else {
                $dataDetails['promo'] = "false";
            }

            if (isset($dataDetails['tnc']) && is_array($dataDetails['tnc'])) {
                $dataDetails['tnc'] = json_encode(array_filter($dataDetails['tnc']));
            } else {
                $dataDetails['tnc'] = null;
            }

            $dataDetails['status'] = "DISABLE";

            Product::create($dataDetails);

            return [
                'status' => 'success',
                'message' => 'Main Product ' . $dataDetails['name'] . ' ' . $dataDetails['type'] . ' successfully created.',
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    public function updateStatusProduct($dataId, $newDetailsData)
    {
        try {

            $product = Product::findOrFail($dataId);
            $product->update(['status' => $newDetailsData['status']]);

            return [
                'status' => 'success',
                'message' => 'Status Main Product ' . $product->name . ' ' . $product->type . ' successfully updated ' . $newDetailsData['status'],
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    public function findByIdProductMain($id)
    {
        return Product::findOrFail($id);
    }

    public function updateProduct($dataId, $newDetailsData)
    {
        try {

            $id = Product::findOrFail($dataId);

            $newDetailsData['picture'] = $newDetailsData['picture'] ?? $id->picture;

            if ($newDetailsData['picture'] != $id->picture) {

                $oldImagePath = public_path('images/picture/products-main/' . $id->picture);

                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }

                $file = $newDetailsData['picture'];
                $filename = $this->generateFilename($file);
                $file->move(public_path('images/picture/products-main'), $filename);
                $newDetailsData['picture'] = $filename;
            }

            if (isset($newDetailsData['tnc']) && is_array($newDetailsData['tnc'])) {
                $newDetailsData['tnc'] = json_encode(array_filter($newDetailsData['tnc']));
            } else {
                $newDetailsData['tnc'] = null;
            }

            $id->update($newDetailsData);

            return [
                'status' => 'success',
                'message' => 'Main Product ' . $id->name . ' ' . $id->type . ' updated successfully.',
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }

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
