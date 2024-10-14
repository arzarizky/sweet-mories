<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\PromoRepositoryInterface;
use Illuminate\Support\Arr;
use App\Models\Promo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class PromoController extends Controller
{
    protected $promoRepository;

    public function __construct(PromoRepositoryInterface $promoRepository)
    {
        $this->promoRepository = $promoRepository;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 5);
        $page = $request->input('page', 1);

        $datas = $this->promoRepository->getAll($search, $perPage);

        if ($datas->isEmpty() && $page > 1) {
            return redirect()->route('user-manager', [
                'search' => $search,
                'per_page' => $perPage,
                'page' => 1
            ]);
        }

        // Pass parameters to the view
        return view('pages.promo-manager.index', compact('datas', 'search', 'perPage', 'page'));
    }

    public function create(Request $request)
    {
        $createMainProduct = $this->promoRepository->create($request->all());
        if ($createMainProduct['status'] === 'success') {
            return redirect()->route('promo-manager')->with('success', $createMainProduct['message']);
        } else {
            return redirect()->route('promo-manager')->with('error', $createMainProduct['message']);
        }
    }

    public function updatePromoStatus(Request $request, $id)
    {
        $newDetails = Arr::except($request->all(), ['_token', '_method']);
        $this->promoRepository->updatePromoStatus($id, $newDetails);
        return redirect()->back()->with('success',  'Status berhasil diubah');
    }

    public function updatePromo(Request $request, $id)
    {
        $newDetails = Arr::except($request->all(), ['_token', '_method']);
        $updatePromo = $this->promoRepository->updatePromo($id, $newDetails);
        if ($updatePromo['status'] === 'success') {
            return redirect()->route('promo-manager')->with('success', $updatePromo['message']);
        } else {
            return redirect()->route('promo-manager')->with('error', $updatePromo['message']);
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
                'model' => $checkCode->model
            ];
        } else {
            return [
                'valid' => true,
                'discount' => $checkCode->discount_percentage,
                'model' => $checkCode->model
            ];
        }
    }
}
