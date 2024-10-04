<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\ProductRepositoryInterface;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function indexProductMain(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 5);
        $page = $request->input('page', 1);

        $datas = $this->productRepository->getAllProduct($search, $perPage);
        // dd($datas);

        if ($datas->isEmpty() && $page > 1) {
            return redirect()->route('invoice-manager', [
                'search' => $search,
                'per_page' => $perPage,
                'page' => 1
            ]);
        }

        // Pass parameters to the view
        return view('pages.produk-manager.product-main.index', compact('datas', 'search', 'perPage', 'page'));
    }

    public function addProductMain()
    {
        return view('pages.produk-manager.product-main.add');
    }
}
