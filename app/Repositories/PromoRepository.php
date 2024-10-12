<?php

namespace App\Repositories;

use App\Interfaces\PromoRepositoryInterface;
use App\Models\Promo;
use Illuminate\Support\Str;

class PromoRepository implements PromoRepositoryInterface
{
    public function generateUniquePromoCode()
    {
        $length = 6;
        $promoCount = Promo::count();
        $maxCodes = pow(26, $length);
        $attempts = 0;
        $maxAttempts = 100;

        while ($promoCount >= $maxCodes) {
            $length++;
            $maxCodes = pow(26, $length);
        }

        do {
            $code = strtoupper(Str::random($length));
            $exists = Promo::where('code', $code)->exists();
            $attempts++;
        } while ($exists && $attempts < $maxAttempts);

        if ($attempts >= $maxAttempts) {
            return [
                'status' => 'error',
                'message' => "Unable to generate a unique promo code after " .$maxAttempts. " attempts."
            ];
        }

        return [
            'status' => 'success',
            'message' => $code
        ];
    }

    public function getAll($search, $page)
    {
        $model = Promo::orderBy('updated_at','desc');

        if ($search === null) {
            $query = $model;
            return $query->paginate($page);
        } else {
            $query = $model->where('name', 'like', '%'.$search.'%')->orWhere('code', 'like', '%' . $search . '%')
            ->orderBy('updated_at','desc');
            return $query->paginate($page);
        }
    }

    public function create($dataDetails)
    {
        try {

            if ($dataDetails['discount_value'] != null && $dataDetails['discount_percentage'] != null) {
                return [
                    'status' => 'error',
                    'message' => "Promo Model Harus Dipilih Salah Satu Menggunakan Number Atau Percentage"
                ];
            }

            if ($dataDetails['discount_value']) {
                $dataDetails['model'] = "NUMBER";
            } else {
                $dataDetails['model'] = "PERCENTAGE";
            }

            $code = $this->generateUniquePromoCode();

            if ($code['status'] === 'error') {
                return [
                    'status' => 'error',
                    'message' => $code['message']
                ];
            } else {
                $dataDetails['code'] = $code['message'];
            }

            Promo::create($dataDetails);

            return [
                'status' => 'success',
                'message' => 'Promo ' . $dataDetails['name'] . ' kode '. $dataDetails['code'] .' successfully created.',
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    public function updatePromoStatus($id, $newDetails)
    {
        Promo::where('id', $id)->update(['is_active' => $newDetails['is_active']]);
    }

    public function updatePromo($id, $newDetails)
    {
        try {

            if ($newDetails['discount_value'] != null && $newDetails['discount_percentage'] != null) {
                return [
                    'status' => 'error',
                    'message' => "Promo Model Harus Dipilih Salah Satu Menggunakan Number Atau Percentage"
                ];
            }

            if ($newDetails['discount_value']) {
                $newDetails['model'] = "NUMBER";
            } else {
                $newDetails['model'] = "PERCENTAGE";
            }

            $query = Promo::where('id', $id);
            $query->update($newDetails);

            return [
                'status' => 'success',
                'message' => 'Promo ' . $query->first()->name . ' kode '. $query->first()->code .' successfully updated.',
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }
}
