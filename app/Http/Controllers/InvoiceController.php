<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\InvoiceRepositoryInterface;
use Illuminate\Support\Arr;


class InvoiceController extends Controller
{
    protected $invoiceRepository;

    public function __construct(InvoiceRepositoryInterface $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 5);
        $page = $request->input('page', 1);

        $datas = $this->invoiceRepository->getAll($search, $perPage);

        if ($datas->isEmpty() && $page > 1) {
            return redirect()->route('invoice-manager', [
                'search' => $search,
                'per_page' => $perPage,
                'page' => 1
            ]);
        }

        // Pass parameters to the view
        return view('pages.invoice-manager.index', compact('datas', 'search', 'perPage', 'page'));
    }
}
