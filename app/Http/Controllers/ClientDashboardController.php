<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Interfaces\BookingRepositoryInterface;
use App\Interfaces\UserManagerRepositoryInterface;
use App\Http\Requests\UserManager\UpdateRequest as UserUpdate;
use App\Interfaces\InvoiceRepositoryInterface;
use Illuminate\Support\Arr;

class ClientDashboardController extends Controller
{
    protected $bookingRepository;
    protected $userManagerRepository;
    protected $invoiceRepository;

    public function __construct(BookingRepositoryInterface $bookingRepository, UserManagerRepositoryInterface $userManagerRepository, InvoiceRepositoryInterface $invoiceRepository)
    {
        $this->bookingRepository = $bookingRepository;
        $this->userManagerRepository = $userManagerRepository;
        $this->invoiceRepository = $invoiceRepository;
    }

    public function index(Request $request, $email)
    {
        $users = Auth::user();
        if ($users->email === $email) {
            // Pass parameters to the view
            return view('pages.client.account.index', compact('users'))->with('success', 'Sukses login sesi telah dibuat');

        } else {
            Session::flush();
            Auth::logout();
            return redirect()->route('auth.login')->with('error', 'Silahkan Login');
        }
    }

    public function update(UserUpdate $request, $email, $id)
    {
        $users = Auth::user();
        if ($users->id === $id) {
            $newDetails = Arr::except($request->all(),['_token', '_method']);
            $this->userManagerRepository->update($users->id, $newDetails);
            return redirect()->back()->with('success',  'Account '.$request->name.' berhasil diubah');
        } else {
            Session::flush();
            Auth::logout();
            return redirect()->route('auth.login')->with('error', 'Silahkan Login');
        }
    }

    public function booking(Request $request, $email)
    {
        $users = Auth::user();
        if ($users->email === $email) {
            $search = $request->input('search');
            $perPage = $request->input('per_page', 6);
            $page = $request->input('page', 1);

            $datas = $this->bookingRepository->getClient($search, $perPage);

            if ($datas->isEmpty() && $page > 1) {
                return redirect()->route('booking-manager', [
                    'search' => $search,
                    'per_page' => $perPage,
                    'page' => 1
                ]);
            }

            // Pass parameters to the view
            return view('pages.client.booking.index', compact('datas', 'users', 'search', 'perPage', 'page'));

        } else {
            Session::flush();
            Auth::logout();
            return redirect()->route('auth.login')->with('error', 'Silahkan Login');
        }
    }

    public function invoice(Request $request, $email)
    {
        $users = Auth::user();
        if ($users->email === $email) {
            $search = $request->input('search');
            $perPage = $request->input('per_page', 6);
            $page = $request->input('page', 1);

            $datas = $this->invoiceRepository->getClient($search, $perPage);

            if ($datas->isEmpty() && $page > 1) {
                return redirect()->route('booking-manager', [
                    'search' => $search,
                    'per_page' => $perPage,
                    'page' => 1
                ]);
            }

            // Pass parameters to the view
            return view('pages.client.invoice.index', compact('datas', 'users', 'search', 'perPage', 'page'));

        } else {
            Session::flush();
            Auth::logout();
            return redirect()->route('auth.login')->with('error', 'Silahkan Login');
        }
    }

}
