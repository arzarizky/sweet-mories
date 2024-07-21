<?php

namespace App\Interfaces;

interface InvoiceRepositoryInterface
{
    public function getAll($search, $page);
    public function getById($dataId);
    public function create($detailsData);
}
