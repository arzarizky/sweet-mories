<?php

namespace App\Interfaces;

interface BookingRepositoryInterface
{
    public function getAll($search, $page, $date, $status);
    public function getById($dataId);
    public function getClient($search, $page);
    public function create($detailsData);
    public function updateStatusBook($dataId, $newDetailsData);
    public function reschedule($dataId);
    public function UpdateReschedule($dataId, $newDetailsData);
}
