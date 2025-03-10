<?php

namespace App\Interfaces;

interface OutletRepositoryInterface
{
    public function getAll($search, $page);
    public function create($detailsData);
    public function updateOutletSettingStatus($id, $newDetails);
    public function updateOutletSetting($id, $newDetails);
}
