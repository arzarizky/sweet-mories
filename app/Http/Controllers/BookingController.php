<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\BookingRepositoryInterface;

class BookingController extends Controller
{
    protected $BookingRepository;

    public function __construct(BookingRepositoryInterface $BookingRepository)
    {
        $this->BookingRepository = $BookingRepository;
    }

    public function index()
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 5);
        $page = $request->input('page', 1);

        $datas = $this->userManagerRepository->getAll($search, $perPage);

        if ($datas->isEmpty() && $page > 1) {
            return redirect()->route('user-manager', [
                'search' => $search,
                'per_page' => $perPage,
                'page' => 1
            ]);
        }

        // Pass parameters to the view
        return view('pages.user-manager.index', compact('datas', 'search', 'perPage', 'page'));
    }
}
