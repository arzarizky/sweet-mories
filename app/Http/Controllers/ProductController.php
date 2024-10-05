<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Arr;

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

    public function createProductMain(Request $request)
    {
        $createMainProduct = $this->productRepository->createProduct($request->all());

        if ($createMainProduct['status'] === 'success') {
            return redirect()->route('product-manager-product-main')->with('success', $createMainProduct['message']);
        } else {
            return redirect()->route('product-manager-product-main-add')->with('error', $createMainProduct['message']);
        }
    }

    public function updateStatusProductMain(Request $request, $id)
    {
        $newDetails = Arr::except($request->all(), ['_token', '_method']);
        $updateStatusProductMain = $this->productRepository->updateStatusProduct($id, $newDetails);

        if ($updateStatusProductMain['status'] === 'success') {
            return redirect()->route('product-manager-product-main')->with('success', $updateStatusProductMain['message']);
        } else {
            return redirect()->route('product-manager-product-main-add')->with('error', $updateStatusProductMain['message']);
        }
    }

    public function editProductMain($id)
    {
        $data = $this->productRepository->findByIdProductMain($id);
        return view('pages.produk-manager.product-main.edit', compact('data'));
    }

    public function updateProductMain(Request $request, $id)
    {
        $newDetails = Arr::except($request->all(), ['_token', '_method']);
        $updateProductMain = $this->productRepository->updateProduct($id, $newDetails);

        if ($updateProductMain['status'] === 'success') {
            return redirect()->route('product-manager-product-main')->with('success', $updateProductMain['message']);
        } else {
            return redirect()->route('product-manager-product-main-edit', $id)->with('error', $updateProductMain['message']);
        }
    }
}
