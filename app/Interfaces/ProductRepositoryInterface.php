<?php

namespace App\Interfaces;

interface ProductRepositoryInterface
{
    public function getAllProduct($search, $page);
    public function createProduct($detailsData);
    public function updateStatusProduct($dataId, $newDetailsData);
    public function findByIdProductMain($id);
    public function updateProduct($dataId, $newDetailsData);

    public function getAllProductAdditional($search, $page);
    public function createProductAdditional($detailsData);
    public function updateStatusProductAdditional($id, $newDetails);
    public function findByIdProductAdditional($id);
    public function updateProductAdditional($dataId, $newDetailsData);

    public function getAllProductBackground($search, $page);
    public function createProductBackground($detailsData);
    public function updateStatusProductBackground($id, $newDetails);
    public function findByIdProductBackground($id);
    public function updateProductBackground($dataId, $newDetailsData);

    public function getAllProductDisplay($search, $page);
    public function createProductDisplay($detailsData);
    public function updateStatusProductDisplay($id, $newDetails);
    public function findByIdProductDisplay($id);
    public function updateProductDisplay($dataId, $newDetailsData);

    public function getAllProductType();
    public function displayProduct();
    public function productAddtionalLP();

}
