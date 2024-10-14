<?php

namespace App\Interfaces;

interface PromoRepositoryInterface
{
    public function getAll($search, $page);
    public function create($detailsData);
    public function updatePromoStatus($id, $newDetails);
    public function updatePromo($id, $newDetails);
    public function checkPromo($detailsData);
}
