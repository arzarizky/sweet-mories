<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\PromoRepositoryInterface;
use Illuminate\Support\Arr;

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
}
