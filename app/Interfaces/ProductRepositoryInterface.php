<?php

namespace App\Interfaces;

interface ProductRepositoryInterface
{
    public function getAllProduct($search, $page);
    public function getAllProductAdditional($search, $page);
    public function getAllProductBackground($search, $page);
    public function getAllProductDisplay($search, $page);
    public function createProduct($detailsData);
    public function createProductAdditional($detailsData);
    public function createProductBackground($detailsData);
    public function createProductDisplay($detailsData);
    public function getById($dataId);
}
