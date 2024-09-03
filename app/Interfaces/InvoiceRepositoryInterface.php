<?php

namespace App\Interfaces;

interface InvoiceRepositoryInterface
{
    public function getAll($search, $page);
    public function getById($dataId);
    public function getByIdBooking($dataId);
    public function getClient($search, $perPage);
    public function create($detailsData);
}
