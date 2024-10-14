<?php

namespace App\Repositories;

use App\Interfaces\PromoRepositoryInterface;
use App\Models\Promo;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PromoRepository implements PromoRepositoryInterface
{
    public function generateUniquePromoCode()
    {
        $length = 6;
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $maxCodes = pow(26, $length);
        $promoCount = Promo::count();

        while ($promoCount >= $maxCodes) {
            $length++;
            $maxCodes = pow(26, $length);
        }

        $usedCodes = Promo::pluck('code')->toArray();
        $attempts = 0;
        $maxAttempts = 100;

        do {

            $code = '';
            for ($i = 0; $i < $length; $i++) {
                $code .= $characters[random_int(0, strlen($characters) - 1)];
            }

            $exists = in_array($code, $usedCodes);
            $attempts++;
        } while ($exists && $attempts < $maxAttempts);

        if ($attempts >= $maxAttempts) {
            return [
                'status' => 'error',
                'message' => "Unable to generate a unique promo code after " . $maxAttempts . " attempts."
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

        if ($search === "ENABLE") {
            $query = $model->where('is_active', $search)->where('type', 'USER')->get();
            return $query;
        }

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

            if ($dataDetails['end_date'] <= $dataDetails['start_date']) {
                return [
                    'status' => 'error',
                    'message' => 'Selesai Promo Tidak Boleh Lebih Awal Atau Sama Dari Mulai Promo'
                ];
            }

            if ($dataDetails['discount_value'] != null && $dataDetails['discount_percentage'] != null) {
                return [
                    'status' => 'error',
                    'message' => "Promo Model Harus Dipilih Salah Satu Menggunakan Number Atau Percentage"
                ];
            }

            if ($dataDetails['discount_value']  != null) {
                $dataDetails['model'] = "NUMBER";
            } else {
                $dataDetails['model'] = "PERCENTAGE";
            }

            if($dataDetails['code'] === null) {
                $code = $this->generateUniquePromoCode();
                if ($code['status'] === 'error') {
                    return [
                        'status' => 'error',
                        'message' => $code['message']
                    ];
                } else {
                    $dataDetails['code'] = $code['message'];
                }
            } else {
                $code = $dataDetails['code'];
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

            if ($newDetails['end_date'] <= $newDetails['start_date']) {
                return [
                    'status' => 'error',
                    'message' => 'Selesai Promo Tidak Boleh Lebih Awal Atau Sama Dari Mulai Promo'
                ];
            }

            if ($newDetails['discount_value'] != null && $newDetails['discount_percentage'] != null) {
                return [
                    'status' => 'error',
                    'message' => "Promo Model Harus Dipilih Salah Satu Menggunakan Number Atau Percentage"
                ];
            }

            if ($newDetails['discount_value'] != null) {
                $newDetails['model'] = "NUMBER";
            } else {
                $newDetails['model'] = "PERCENTAGE";
            }

            if($newDetails['code'] === null) {
                $code = $this->generateUniquePromoCode();
                if ($code['status'] === 'error') {
                    return [
                        'status' => 'error',
                        'message' => $code['message']
                    ];
                } else {
                    $newDetails['code'] = $code['message'];
                }
            } else {
                $code = $newDetails['code'];
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

    public function checkPromo($promo)
    {
        $checkCode = Promo::where('code', $promo)
            ->where('is_active', "ENABLE")
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->first(['id', 'type', 'usage_limit', 'used_count', 'model', 'discount_value', 'discount_percentage']);

        if (!$checkCode) {
            return ['valid' => false];
        }

        if ($checkCode->usage_limit === $checkCode->used_count) {
            return ['valid' => false];
        }

        if ($checkCode->type === "USER") {
            $userId = Auth::user()->id;
            $userPromo = User::where('id', $userId)->value('promo_id');

            if ($userPromo && $userPromo === $checkCode->id) {
                return self::getDiscount($checkCode);
            }

            return ['valid' => false];
        }

        return self::getDiscount($checkCode);
    }

    public function getDiscount($checkCode)
    {
        if ($checkCode->model === "NUMBER") {
            return [
                'valid' => true,
                'discount' => $checkCode->discount_value,
                'model' => $checkCode->model,
                'id_promo' =>  $checkCode->id
            ];
        } else {
            return [
                'valid' => true,
                'discount' => $checkCode->discount_percentage,
                'model' => $checkCode->model,
                'id_promo' =>  $checkCode->id
            ];
        }
    }
}
