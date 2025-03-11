<?php

namespace App\Repositories;

use App\Interfaces\OutletRepositoryInterface;
use App\Models\OutletSetting;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OutletRepository implements OutletRepositoryInterface
{
    public function getAll($search, $page)
    {
        $model = OutletSetting::orderBy('updated_at','desc');

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
            // Pastikan semua data yang dibutuhkan tersedia
            if (!isset($dataDetails['start_day'], $dataDetails['start_time'], $dataDetails['end_day'], $dataDetails['end_time'])) {
                return [
                    'status' => 'error',
                    'message' => 'Data waktu tidak lengkap.',
                ];
            }

            // Validasi format tanggal & waktu
            $startDateTime = Carbon::parse("{$dataDetails['start_day']} {$dataDetails['start_time']}");
            $endDateTime = Carbon::parse("{$dataDetails['end_day']} {$dataDetails['end_time']}");

            // Cek apakah waktu penutupan lebih awal dari waktu pembukaan
            if ($endDateTime < $startDateTime) {
                return [
                    'status' => 'error',
                    'message' => 'Close Outlet tidak boleh lebih awal dari Mulai Outlet.',
                ];
            }

            // Simpan data ke database dalam transaksi
            DB::transaction(function () use ($dataDetails) {
                OutletSetting::create($dataDetails);
            });

            return [
                'status' => 'success',
                'message' => 'Close Outlet ' . ($dataDetails['name'] ?? 'Tanpa Nama') . ' berhasil dibuat.',
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
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

    public function editOutletSettingStatus($id)
    {
        $model = OutletSetting::find($id);
        return $model;
    }

    public function updateOutletSetting($id, $newDetails)
    {
        try {

            // Pastikan semua data yang dibutuhkan tersedia
            if (!isset($newDetails['start_day'], $newDetails['start_time'], $newDetails['end_day'], $newDetails['end_time'])) {
                return [
                    'status' => 'error',
                    'message' => 'Data waktu tidak lengkap.',
                ];
            }

            // Parsing tanggal & waktu
            $startDateTime = Carbon::parse("{$newDetails['start_day']} {$newDetails['start_time']}");
            $endDateTime = Carbon::parse("{$newDetails['end_day']} {$newDetails['end_time']}");

            // Validasi waktu
            if ($endDateTime < $startDateTime) {
                return [
                    'status' => 'error',
                    'message' => 'Close Outlet tidak boleh lebih awal dari Mulai Outlet.'
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

            // Update data dalam transaksi
            DB::transaction(function () use ($outletSetting, $newDetails) {
                $outletSetting->update($newDetails);
            });

            return [
                'status' => 'success',
                'message' => 'Close Outlet ' . ($outletSetting->name ?? 'Tanpa Nama') . ' berhasil diperbarui.',
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ];
        }
    }
}
