<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\BookingRepositoryInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Booking;
use Carbon\Carbon;


class BookingController extends Controller
{
    protected $bookingRepository;

    public function __construct(BookingRepositoryInterface $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    public function index(Request $request)
    {
        $search = $request->input('search',);
        $date = $request->input('date', null);
        $perPage = $request->input('per_page', 5);
        $page = $request->input('page', 1);

        $datas = $this->bookingRepository->getAll($search, $perPage, $date);

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

    public function bookPreview(Request $request, $email)
    {
        // dd($request);
        $users = Auth::user();
        if ($users->email === $email) {

            // dd($email, $request->package);
            // Pass parameters to the view
            return view('pages.client.booking-preview.index', compact('users'));
        } else {
            Session::flush();
            Auth::logout();
            return redirect()->route('book-now-landing')->with('error', 'Silahkan Login');
        }
    }

    public function checkDate(Request $request)
    {
        $date = $request->date;
        $bookedCount = Booking::where('booking_date', $date)
            ->where('status', 'on process') // Memfilter hanya booking dengan status "on process"
            ->count();

        // Menghitung total slot, yaitu 36 slot (12 jam, masing-masing 20 menit)
        $totalSlots = (12 * 60) / 20; // 720 menit dibagi 20 menit per slot

        if ($bookedCount >= $totalSlots) {
            return response()->json(['allBooked' => true]);
        }

        return response()->json(['allBooked' => false]);
    }

    public function checkTime(Request $request)
    {
        $date = $request->date;

        // Ambil semua waktu yang statusnya EXP di tanggal tertentu
        $bookedTimes = Booking::where('booking_date', $date)
            ->where(function ($query) {
                $query->where('status', ['PENDING', 'PAYMENT PROCESS', 'ON PROCESS', 'DONE']) // Ambil status EXP
                    ->orWhere(function ($query) {
                        // Cek apakah status EXP ada
                        $query->whereNotIn('status', ['EXP']);
                    });
            })
            ->pluck('booking_time')
            ->map(function ($time) {
                return Carbon::parse($time)->format('H:i');
            })
            ->toArray();

        return response()->json(['bookedTimes' => $bookedTimes]);
    }

    public function store(Request $request)
    {
        if ($request->no_tlp == null) {
            return redirect()->route('book-now-landing', ['email' =>  Auth::user()->email])->with('error', "WA Harus Diisi");
        } else {
            $datas = $this->bookingRepository->create($request->all());
            if ($datas["sukses"] === true) {
                return redirect()->route('client-booking', ['email' =>  Auth::user()->email])->with('success', $datas["pesan"]);
            } else {
                return redirect()->route('book-now-landing', ['email' =>  Auth::user()->email])->with('error', $datas["pesan"]);
            }
        }
    }

    public function updateBookStatus(Request $request, $id)
    {
        $newDetails = Arr::except($request->all(), ['_token', '_method']);
        $this->bookingRepository->updateStatusBook($id, $newDetails);

        return redirect()->back()->with('success',  'Status berhasil diubah');
    }

    public function reschedule(Request $request, $id)
    {
        $datas = $this->bookingRepository->reschedule($id);
        return view('pages.booking-manager.reschedule.index', compact('datas'));
    }

    public function UpdateReschedule(Request $request, $id)
    {
        $newDetails = Arr::except($request->all(), ['_token', '_method']);
        $dataUpdate = $this->bookingRepository->UpdateReschedule($id, $newDetails);
        return redirect()->back()->with('success',  'Booking Berhasil Di Reschedule Ke Tanggal ' . $dataUpdate['date'] . ' Pukul ' .  $dataUpdate['time']);
    }
}
