<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\BookingRepositoryInterface;
use Illuminate\Support\Arr;

class BookingController extends Controller
{
    protected $bookingRepository;

    public function __construct(BookingRepositoryInterface $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 5);
        $page = $request->input('page', 1);

        $datas = $this->bookingRepository->getAll($search, $perPage);

        if ($datas->isEmpty() && $page > 1) {
            return redirect()->route('booking-manager', [
                'search' => $search,
                'per_page' => $perPage,
                'page' => 1
            ]);
        }

        // Pass parameters to the view
        return view('pages.booking-manager.index', compact('datas', 'search', 'perPage', 'page'));
    }

    public function bookPreview(Request $request)
    {
        dd($request);
    }

    public function updateBookStatus(Request $request, $id)
    {
        $newDetails = Arr::except($request->all(),['_token', '_method']);
        $this->bookingRepository->updateStatusBook($id, $newDetails);

        return redirect()->back()->with('success',  'Status berhasil diubah');
    }
}
