<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\InvoiceRepositoryInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;


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

    public function create(Request $request)
    {
        $cekIdBooking = $this->invoiceRepository->getByIdBooking($request->book_id)->count();

        if ($cekIdBooking === 0) {
            $datas = $this->invoiceRepository->create($request->all());

            if ($datas["success"] === true) {
                return redirect()->away($datas["payment_link"]);
            }

            if ($datas["success"] === false) {
                if ($datas["error_type"] === "apps") {
                    return redirect()->route('client-booking', ['email' =>  Auth::user()->email])->with('error', $request->book_id . " " . $datas["message"]);
                } elseif ($datas["error_type"] === "payment_gateway") {
                    return redirect()->route('client-booking', ['email' =>  Auth::user()->email])->with('error', $request->book_id . " Error Payment Gateway " . $datas["message"]);
                } else {
                    return redirect()->route('client-booking', ['email' =>  Auth::user()->email])->with('error', $request->book_id . " Error Tidak Terdefinisi");
                }
            }

        } else {
            return redirect()->route('client-booking', ['email' =>  Auth::user()->email])->with('error', $request->book_id . " Sudah dibuat invoice");
        }
    }
}
