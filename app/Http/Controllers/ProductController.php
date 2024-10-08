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

        if ($datas->isEmpty() && $page > 1) {
            return redirect()->route('invoice-manager', [
                'search' => $search,
                'per_page' => $perPage,
                'page' => 1
            ]);
        }

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
            return redirect()->route('product-manager-product-main')->with('error', $updateStatusProductMain['message']);
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

    public function indexProductAddtional(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 5);
        $page = $request->input('page', 1);

        $datas = $this->productRepository->getAllProductAdditional($search, $perPage);

        if ($datas->isEmpty() && $page > 1) {
            return redirect()->route('invoice-manager', [
                'search' => $search,
                'per_page' => $perPage,
                'page' => 1
            ]);
        }

        return view('pages.produk-manager.product-additional.index', compact('datas', 'search', 'perPage', 'page'));
    }

    public function addProducAddtional()
    {
        return view('pages.produk-manager.product-additional.add');
    }

    public function createProductAddtional(Request $request)
    {
        $createAdditionalProduct = $this->productRepository->createProductAdditional($request->all());

        if ($createAdditionalProduct['status'] === 'success') {
            return redirect()->route('product-manager-product-addtional')->with('success', $createAdditionalProduct['message']);
        } else {
            return redirect()->route('product-manager-product-additional-add')->with('error', $createAdditionalProduct['message']);
        }
    }

    public function updateStatusProductAdditional(Request $request, $id)
    {
        $newDetails = Arr::except($request->all(), ['_token', '_method']);
        $updateStatusProductAdditional = $this->productRepository->updateStatusProductAdditional($id, $newDetails);

        if ($updateStatusProductAdditional['status'] === 'success') {
            return redirect()->route('product-manager-product-addtional')->with('success', $updateStatusProductAdditional['message']);
        } else {
            return redirect()->route('product-manager-product-addtional')->with('error', $updateStatusProductAdditional['message']);
        }
    }

    public function editProductAdditional($id)
    {
        $data = $this->productRepository->findByIdProductAdditional($id);
        return view('pages.produk-manager.product-additional.edit', compact('data'));
    }

    public function updateProductAdditional(Request $request, $id)
    {
        $newDetails = Arr::except($request->all(), ['_token', '_method']);
        $updateProductAdditional = $this->productRepository->updateProductAdditional($id, $newDetails);

        if ($updateProductAdditional['status'] === 'success') {
            return redirect()->route('product-manager-product-addtional')->with('success', $updateProductAdditional['message']);
        } else {
            return redirect()->route('product-manager-product-additional-edit', $id)->with('error', $updateProductAdditional['message']);
        }
    }

    public function indexProductBackground(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 5);
        $page = $request->input('page', 1);

        $datas = $this->productRepository->getAllProductBackground($search, $perPage);

        if ($datas->isEmpty() && $page > 1) {
            return redirect()->route('invoice-manager', [
                'search' => $search,
                'per_page' => $perPage,
                'page' => 1
            ]);
        }

        return view('pages.produk-manager.product-background.index', compact('datas', 'search', 'perPage', 'page'));
    }

    public function addProducBackground()
    {
        return view('pages.produk-manager.product-background.add');
    }

    public function createProductBackground(Request $request)
    {
        $createBackgroundProduct = $this->productRepository->createProductBackground($request->all());

        if ($createBackgroundProduct['status'] === 'success') {
            return redirect()->route('product-manager-product-background')->with('success', $createBackgroundProduct['message']);
        } else {
            return redirect()->route('product-manager-product-background-add')->with('error', $createBackgroundProduct['message']);
        }
    }

    public function updateStatusProductBackground(Request $request, $id)
    {
        $newDetails = Arr::except($request->all(), ['_token', '_method']);
        $updateStatusProduct = $this->productRepository->updateStatusProductBackground($id, $newDetails);

        if ($updateStatusProduct['status'] === 'success') {
            return redirect()->route('product-manager-product-background')->with('success', $updateStatusProduct['message']);
        } else {
            return redirect()->route('product-manager-product-background')->with('error', $updateStatusProduct['message']);
        }
    }

    public function editProductBackround($id)
    {
        $data = $this->productRepository->findByIdProductBackground($id);
        return view('pages.produk-manager.product-background.edit', compact('data'));
    }

    public function updateProductBackground(Request $request, $id)
    {
        $newDetails = Arr::except($request->all(), ['_token', '_method']);
        $updateProductBackground = $this->productRepository->updateProductBackground($id, $newDetails);

        if ($updateProductBackground['status'] === 'success') {
            return redirect()->route('product-manager-product-background')->with('success', $updateProductBackground['message']);
        } else {
            return redirect()->route('product-manager-product-background-edit', $id)->with('error', $updateProductBackground['message']);
        }
    }

    public function indexProductDisplay(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 5);
        $page = $request->input('page', 1);

        $datas = $this->productRepository->getAllProductDisplay($search, $perPage);

        if ($datas->isEmpty() && $page > 1) {
            return redirect()->route('invoice-manager', [
                'search' => $search,
                'per_page' => $perPage,
                'page' => 1
            ]);
        }

        return view('pages.produk-manager.product-display.index', compact('datas', 'search', 'perPage', 'page'));
    }

    public function addProductDisplay()
    {
        $getAllProductType = $this->productRepository->getAllProductType();
        $products = $getAllProductType['product'];
        $ProductAdditionals = $getAllProductType['ProductAdditional'];
        $ProductBackgrounds = $getAllProductType['ProductBackground'];

        return view('pages.produk-manager.product-display.add', compact('products', 'ProductAdditionals', 'ProductBackgrounds'));
    }

    public function createProductDisplay(Request $request)
    {
        $createDisplayProduct = $this->productRepository->createProductDisplay($request->all());

        if ($createDisplayProduct['status'] === 'success') {
            return redirect()->route('product-manager-product-display')->with('success', $createDisplayProduct['message']);
        } else {
            return redirect()->route('product-manager-product-display-add')->with('error', $createDisplayProduct['message']);
        }
    }

    public function updateStatusProductDisplay(Request $request, $id)
    {
        $newDetails = Arr::except($request->all(), ['_token', '_method']);
        $updateStatusProductDisplay = $this->productRepository->updateStatusProductDisplay($id, $newDetails);

        if ($updateStatusProductDisplay['status'] === 'success') {
            return redirect()->route('product-manager-product-display')->with('success', $updateStatusProductDisplay['message']);
        } else {
            return redirect()->route('product-manager-product-display')->with('error', $updateStatusProductDisplay['message']);
        }
    }

    public function editProductDisplay($id)
    {
        $data = $this->productRepository->findByIdProductDisplay($id);
        $getAllProductType = $this->productRepository->getAllProductType();
        $products = $getAllProductType['product'];
        $ProductAdditionals = $getAllProductType['ProductAdditional'];
        $ProductBackgrounds = $getAllProductType['ProductBackground'];

        return view('pages.produk-manager.product-display.edit', compact('data', 'products', 'ProductAdditionals', 'ProductBackgrounds'));

    }

    public function updateProductDisplay(Request $request, $id)
    {
        $newDetails = Arr::except($request->all(), ['_token', '_method']);
        $updateProductDisplay = $this->productRepository->updateProductDisplay($id, $newDetails);

        if ($updateProductDisplay['status'] === 'success') {
            return redirect()->route('product-manager-product-display')->with('success', $updateProductDisplay['message']);
        } else {
            return redirect()->route('product-manager-product-display-edit', $id)->with('error', $updateProductDisplay['message']);
        }
    }
}



