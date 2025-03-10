<?php

namespace App\Repositories;

use App\Interfaces\OutletRepositoryInterface;
use App\Models\OutletSetting;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class OutletRepository implements OutletRepositoryInterface
{
    public function getAll($search, $page)
    {
        $model = OutletSetting::orderBy('updated_at','desc');

        if ($search === "ENABLE") {
            $query = $model->where('is_active', $search)->where('type', 'USER')->get();
            return $query;
        }

        if ($search === null) {
            $query = $model;
            return $query->paginate($page);
        } else {
            $query = $model->where('name', 'like', '%'.$search.'%')
            ->orderBy('updated_at','desc');
            return $query->paginate($page);
        }
    }

    public function create($dataDetails)
    {
        try {
            // Validasi: Tanggal dan waktu penutupan tidak boleh lebih awal atau sama dari waktu pembukaan
            $startDateTime = Carbon::createFromFormat('Y-m-d H:i:s', "{$dataDetails['start_day']} {$dataDetails['start_time']}");
            $endDateTime = Carbon::createFromFormat('Y-m-d H:i:s', "{$dataDetails['end_day']} {$dataDetails['end_time']}");

            if ($endDateTime <= $startDateTime) {
                return [
                    'status' => 'error',
                    'message' => 'Close Outlet tidak boleh lebih awal atau sama dari Mulai Outlet.'
                ];
            }

            // Simpan data ke database
            OutletSetting::create($dataDetails);

            return [
                'status' => 'success',
                'message' => 'Close Outlet ' . $dataDetails['name'] . ' successfully created.',
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }


    public function updateOutletSettingStatus($id, $newDetails)
    {
        if ($newDetails["is_active"] === "ENABLE") {
            $hasEnabledSettings = OutletSetting::where('is_active', 'ENABLE')->exists();
            if ($hasEnabledSettings) {
                return [
                    'status' => 'error',
                    'message' => 'Close Outlet tidak boleh lebih dari 1 yang aktif'
                ];
            }
        }

        $currentSetting = OutletSetting::findOrFail($id);
        $currentSetting->update(['is_active' => $newDetails['is_active']]);

        return [
            'status' => 'success',
        ];
    }

    public function updateOutletSetting($id, $newDetails)
    {
        try {

            $startDateTime = Carbon::createFromFormat('Y-m-d H:i:s', "{$newDetails['start_day']} {$newDetails['start_time']}");
            $endDateTime = Carbon::createFromFormat('Y-m-d H:i:s', "{$newDetails['end_day']} {$newDetails['end_time']}");

            if ($endDateTime <= $startDateTime) {
                return [
                    'status' => 'error',
                    'message' => 'Close Outlet tidak boleh lebih awal atau sama dari Mulai Outlet.'
                ];
            }

            // Cari data berdasarkan ID
            $outletSetting = OutletSetting::find($id);

            if (!$outletSetting) {
                return [
                    'status' => 'error',
                    'message' => 'Outlet Setting tidak ditemukan.'
                ];
            }

            // Update data
            $outletSetting->update($newDetails);

            return [
                'status' => 'success',
                'message' => 'Close Outlet ' . $outletSetting->name . ' successfully updated.',
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }
}
