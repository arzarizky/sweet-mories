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



    public function getAllProductDisplay($search, $page);
    public function createProductBackground($detailsData);
    public function createProductDisplay($detailsData);
    public function getById($dataId);
}
