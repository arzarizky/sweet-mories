<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\BookingRepositoryInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Booking;
use Carbon\Carbon;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\OutletSetting;

class BookingController extends Controller
{
    protected $bookingRepository;
    protected $productRepository;

    public function __construct(BookingRepositoryInterface $bookingRepository, ProductRepositoryInterface $productRepository)
    {
        $this->bookingRepository = $bookingRepository;
        $this->productRepository = $productRepository;
    }

    public function index(Request $request)
    {
        $search = $request->input('search', null);
        $date = $request->input('date', null);
        $perPage = (int) $request->input('per_page', 5);
        $page = (int) $request->input('page', 1);
        $status = $request->input('status', null);

        $datas = $this->bookingRepository->getAll($search, $perPage, $date, $status);

        if ($datas->isEmpty() && $page > 1) {
            return redirect()->route('booking-manager', [
                'search' => $search,
                'per_page' => $perPage,
                'page' => 1,
                'date' => $date,
                'status' => $status
            ]);
        }

        return view('pages.booking-manager.index', compact('datas', 'search', 'perPage', 'page', 'date', 'status'));
    }


    public function bookPreview(Request $request, $email, $package)
    {
        $users = Auth::user();
        if ($users->email === $email) {
            $package = $package;
            $productDisplay = $this->productRepository->getAllProductDisplayById($package);
            return view('pages.client.booking-preview.index', compact('users', 'productDisplay'));
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

        // Ambil setting outlet yang mencakup tanggal yang diminta
        $outletSetting = OutletSetting::where('start_day', '<=', $date)
            ->where('end_day', '>=', $date)
            ->where('is_active', 'ENABLE')
            ->first(['start_day', 'start_time', 'end_day', 'end_time']);

        // Ambil semua waktu yang sudah dibooking
        $bookedTimes = Booking::where('booking_date', $date)
            ->whereIn('status', ['PENDING', 'PAYMENT PROCESS', 'ON PROCESS', 'DONE'])
            ->pluck('booking_time')
            ->map(fn($time) => Carbon::parse($time)->format('H:i'))
            ->toArray();

        if (!$outletSetting) {
            return response()->json(['bookedTimes' => $bookedTimes]);
        }

        $startDateTime = Carbon::parse("{$outletSetting->start_day} {$outletSetting->start_time}");
        $endDateTime = Carbon::parse("{$outletSetting->end_day} {$outletSetting->end_time}");

        // Jika waktu mulai dan selesai sama, anggap semua waktu penuh
        if ($startDateTime->equalTo($endDateTime)) {
            return response()->json([
                'bookedTimes' => array_merge($bookedTimes, [$startDateTime->format('H:i')]),
            ]);
        }

         // Tentukan rentang waktu berdasarkan tanggal request
        $startTime = Carbon::parse(($date == $outletSetting->start_day) ? $outletSetting->start_time : '09:00');
        $endTime = Carbon::parse(($date == $outletSetting->end_day) ? $outletSetting->end_time : '21:00');

        // Rentang tutup outlet (09:00 - 21:00)
        $closedStart = Carbon::parse("09:00");
        $closedEnd = Carbon::parse("21:00");

        // Jika rentang waktu mencakup waktu tutup, return closed
        if ($startTime->lessThanOrEqualTo($closedStart) && $endTime->greaterThanOrEqualTo($closedEnd)) {
            return response()->json([
                'closed'  => true,
                'message' => "Pada tanggal $date tutup hingga tanggal $outletSetting->end_day pukul $outletSetting->end_time"
            ]);
        }

        // Generate semua rentang waktu dalam interval 20 menit
        $allTimes = collect(range(0, Carbon::parse($startTime)->diffInMinutes(Carbon::parse($endTime)), 20))
            ->map(fn($minutes) => Carbon::parse($startTime)->addMinutes($minutes)->format('H:i'))
            ->toArray();

        return response()->json([
            'bookedTimes' => array_merge($bookedTimes, $allTimes),
        ]);
    }

    public function store(Request $request)
    {
        if ($request->no_tlp == null) {
            return redirect()->route('book-now-landing', ['email' =>  Auth::user()->email])->with('error', "WA Harus Diisi");
        } else {
            $datas = $this->bookingRepository->create($request->all());
            if ($datas["sukses"] === true) {
                return redirect($datas["pesan"]);
            } else {
                return redirect()->route('client-booking', ['email' =>  Auth::user()->email])->with('error', $datas["pesan"]);
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

    public function indexBookNow()
    {
        $displayProducts = $this->productRepository->displayProduct();
        return view('pages.landing-page.book-now', compact('displayProducts'));
    }

    public function indexPriceList()
    {
        $displayProducts = $this->productRepository->displayProduct();
        $productAddtionalLP = $this->productRepository->productAddtionalLP();
        return view('pages.landing-page.pricelist', compact('displayProducts', 'productAddtionalLP'));
    }
}
