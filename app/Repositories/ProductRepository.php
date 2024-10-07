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

            $newDetailsData['price_promo'] = $newDetailsData['price_promo'] ?? null;

            $pricePromo = $newDetailsData['price_promo'];

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

            if ($pricePromo != null) {
                $newDetailsData['promo'] = "true";
            } else {
                $newDetailsData['promo'] = "false";
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

    public function getAllProductAdditional($search, $page)
    {
        $model = ProductAdditional::orderBy('updated_at','desc');

        if ($search === null) {
            $query = $model;
            return $query->paginate($page);
        } else {
            $query = $model->where('name', 'like', '%'.$search.'%');
            return $query->paginate($page);
        }
    }

    public function createProductAdditional($dataDetails)
    {
        try {
            $dataDetails['status'] = "DISABLE";
            $dataDetails['picture'] = $dataDetails['picture'] ?? null;

            $picture = $dataDetails['picture'];

            if ($picture != null) {
                $file = $dataDetails['picture'];
                $filename = $this->generateFilename($file);
                $file->move(public_path('images/picture/products-additional/'), $filename);
                $dataDetails['picture'] = $filename;
            }

            ProductAdditional::create($dataDetails);

            return [
                'status' => 'success',
                'message' => 'Product Additional ' . $dataDetails['name'] . ' successfully created.',
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    public function updateStatusProductAdditional($dataId, $newDetailsData)
    {
        try {

            $product = ProductAdditional::findOrFail($dataId);
            $product->update(['status' => $newDetailsData['status']]);

            return [
                'status' => 'success',
                'message' => 'Status Product Additional ' . $product->name .  ' successfully updated ' . $newDetailsData['status'],
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    public function findByIdProductAdditional($id)
    {
        return ProductAdditional::findOrFail($id);
    }

    public function updateProductAdditional($dataId, $newDetailsData)
    {
        try {

            $id = ProductAdditional::findOrFail($dataId);

            $newDetailsData['picture'] = $newDetailsData['picture'] ?? $id->picture;

            if ($newDetailsData['picture'] != $id->picture) {

                $oldImagePath = public_path('images/picture/products-additional/' . $id->picture);

                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }

                $file = $newDetailsData['picture'];
                $filename = $this->generateFilename($file);
                $file->move(public_path('images/picture/products-additional'), $filename);
                $newDetailsData['picture'] = $filename;
            }

            $id->update($newDetailsData);

            return [
                'status' => 'success',
                'message' => 'Additional Product ' . $id->name . ' updated successfully.',
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }

    }

    public function getAllProductBackground($search, $page)
    {
        $model = ProductBackground::orderBy('updated_at','desc');

        if ($search === null) {
            $query = $model;
            return $query->paginate($page);
        } else {
            $query = $model->where('name', 'like', '%'.$search.'%');
            return $query->paginate($page);
        }
    }

    public function createProductBackground($dataDetails)
    {
        try {
            $dataDetails['status'] = "DISABLE";
            $dataDetails['picture'] = $dataDetails['picture'] ?? null;

            $picture = $dataDetails['picture'];

            if ($picture != null) {
                $file = $dataDetails['picture'];
                $filename = $this->generateFilename($file);
                $file->move(public_path('images/picture/products-background/'), $filename);
                $dataDetails['picture'] = $filename;
            }

            ProductBackground::create($dataDetails);

            return [
                'status' => 'success',
                'message' => 'Product Background ' . $dataDetails['name'] . ' ' . $dataDetails['type'] . ' successfully created.',
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    public function updateStatusProductBackground($dataId, $newDetailsData)
    {
        try {

            $product = ProductBackground::findOrFail($dataId);
            $product->update(['status' => $newDetailsData['status']]);

            return [
                'status' => 'success',
                'message' => 'Status Product Background ' . $product->name . ' ' .  $product->type .  ' successfully updated ' . $newDetailsData['status'],
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    public function findByIdProductBackground($id)
    {
        return ProductBackground::findOrFail($id);
    }

    public function updateProductBackground($dataId, $newDetailsData)
    {
        try {

            $id = ProductBackground::findOrFail($dataId);

            $newDetailsData['picture'] = $newDetailsData['picture'] ?? $id->picture;

            if ($newDetailsData['picture'] != $id->picture) {

                $oldImagePath = public_path('images/picture/products-background/' . $id->picture);

                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }

                $file = $newDetailsData['picture'];
                $filename = $this->generateFilename($file);
                $file->move(public_path('images/picture/products-background'), $filename);
                $newDetailsData['picture'] = $filename;
            }

            $id->update($newDetailsData);

            return [
                'status' => 'success',
                'message' => 'Product Background ' . $id->name . ' ' . $id->type . ' updated successfully.',
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }

    }

    public function getAllProductDisplay($search, $perPage = 5)
    {
        $model = ProductDisplay::with($this->relationsProductDisplay);

        if ($search) {
            $model = $model->where('name', 'like', '%' . $search . '%');
        }

        $datas = $model->orderBy('updated_at', 'desc')->paginate($perPage);

        foreach ($datas as $productDisplay) {

            $productDisplay->additionalProducts = $productDisplay->getProductAdditionals();

            $productDisplay->backgroundsProducts = $productDisplay->getProductBackground();
        }

        return $datas;
    }


    public function createProductDisplay($dataDetails)
    {
        try {

            $dataDetails['product_additional_id'] = json_encode($dataDetails['product_additional_id']);

            $dataDetails['status'] = $dataDetails['status'] ?? 'DISABLE';

            ProductDisplay::create($dataDetails);

            return [
                'status' => 'success',
                'message' => 'Product Display ' . $dataDetails['name'] . ' successfully created.',
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    public function updateStatusProductDisplay($dataId, $newDetailsData)
    {
        try {

            $product = ProductDisplay::findOrFail($dataId);
            $product->update(['status' => $newDetailsData['status']]);

            return [
                'status' => 'success',
                'message' => 'Status Product Display ' . $product->name . ' ' .  $product->name .  ' successfully updated ' . $newDetailsData['status'],
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    public function findByIdProductDisplay($id)
    {
        return ProductDisplay::findOrFail($id);
    }

    public function updateProductDisplay($dataId, $newDetailsData)
    {
        try {

            $id = ProductDisplay::findOrFail($dataId);

            if (isset($newDetailsData['product_additional_id']) && is_array($newDetailsData['product_additional_id'])) {
                $newDetailsData['product_additional_id'] = json_encode(($newDetailsData['product_additional_id']));
            } else {
                $newDetailsData['product_additional_id'] = null;
            }

            $id->update($newDetailsData);

            return [
                'status' => 'success',
                'message' => 'Product Display ' . $id->name . ' updated successfully.',
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }

    }



    public function getAllProductType()
    {
        try {

            $Product = Product::where('status', 'ENABLE')->get();
            $ProductAdditional = ProductAdditional::where('status', 'ENABLE')->get();
            $ProductBackground = ProductBackground::where('status', 'ENABLE')->get();

            return [
                'product' => $Product,
                'ProductAdditional' => $ProductAdditional,
                'ProductBackground' => $ProductBackground,
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

}
