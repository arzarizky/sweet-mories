<?php

namespace App\Interfaces;

interface BookingRepositoryInterface
{
    public function getAll($search, $page);
    public function getById($dataId);
    public function getClient($search, $page);
    public function create($detailsData);
    public function updateStatusBook($dataId, $newDetailsData);
}
