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

    public function bookPreview(Request $request, $email)
    {
        dd($request);
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

    public function availableDates(Request $request)
    {
        dd($request);
        $dates = Booking::select('booking_date')
                        ->where('booking_date', '>=', Carbon::today())
                        ->groupBy('booking_date')
                        ->pluck('booking_date')
                        ->toArray();

        return response()->json(['availableDates' => $dates]);
    }

    public function availableTimes(Request $request)
    {
        $date = $request->input('date');
        $times = Booking::where('booking_date', $date)->get()

                        ->toArray();

        $allTimes = [];
        $startTime = Carbon::createFromFormat('H:i', '09:00');
        $endTime = Carbon::createFromFormat('H:i', '21:00');

        while ($startTime <= $endTime) {
            $time = $startTime->format('H:i');
            $allTimes[] = $time;
            $startTime->addMinutes(15);
        }

        $availableTimes = array_diff($allTimes, $times);

        return response()->json(['availableTimes' => $availableTimes]);
    }

    public function storeBooking(Request $request)
    {
        $validated = $request->validate([
            'booking_date' => 'required|date',
            'booking_time' => 'required|string',
        ]);

        Booking::create($validated);

        return response()->json(['success' => true, 'message' => 'Booking berhasil!']);
    }



    public function updateBookStatus(Request $request, $id)
    {
        $newDetails = Arr::except($request->all(),['_token', '_method']);
        $this->bookingRepository->updateStatusBook($id, $newDetails);

        return redirect()->back()->with('success',  'Status berhasil diubah');
    }
}
