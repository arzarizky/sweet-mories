<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserManagerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ClientDashboardController;
use App\Models\Invoice;
use App\Models\Booking;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PromoController;
use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// prefix landing page
Route::prefix('/')->group(function () {
    Route::get("/paymentredirect", function (Request $request) {
        $invoice = Invoice::with(['users'])->where('invoice_id', $request->order_id)->first();
        // dd($invoice);
        $booking = Booking::where('book_id', $invoice->book_id)->first();

        if($invoice->status == "PENDING"){
            return redirect()->route('client-booking', ['email' => $invoice->users->email])->with('warning', "Booking " . $invoice->users->email . " pada tanggal " . $booking->booking_date . " pukul " . $booking->booking_time . " belum melakukan pembayaran");
        }
        if($invoice->status == "PAID"){
            return redirect()->route('client-booking', ['email' => $invoice->users->email])->with('success', "Booking " . $invoice->users->email . " pada tanggal " . $booking->booking_date . " pukul " . $booking->booking_time . " berhasil melakukan pembayaran");
        }
        if($invoice->status == "EXP"){
            return redirect()->route('client-booking', ['email' => $invoice->users->email])->with('danger', "Booking " . $invoice->users->email . " pada tanggal " . $booking->booking_date . " pukul " . $booking->booking_time . " pembayaran kadaluarsa");
        }
        if($invoice->status == "CANCELLED"){
            return redirect()->route('client-booking', ['email' => $invoice->users->email])->with('warning', "Booking " . $invoice->users->email . " pada tanggal " . $booking->booking_date . " pukul " . $booking->booking_time . " pembayaran dibatalkan");
        }
    });

    Route::get("/", function () {
        return view('pages.landing-page.home');
    })->name('home-landing');

    Route::get("/portfolio", function () {
        return view('pages.landing-page.portfolio');
    })->name('portfolio-landing');

    Route::get("/gallery", function () {
        return view('pages.landing-page.gallery');
    })->name('gallery-landing');

    Route::get('/pricelist', [BookingController::class, 'indexPriceList'])->name('pricelist-landing');


    Route::get('/book-now', [BookingController::class, 'indexBookNow'])->name('book-now-landing');

    Route::get("/about", function () {
        return view('pages.landing-page.about');
    })->name('about-landing');
});

// prefix login
Route::prefix('login')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('auth.login');
    Route::post('/', [AuthController::class, 'login'])->name('auth.login-post');
});

Route::get('auth/google', [AuthController::class, 'redirectLoginOrRegisterWithGoogle'])->name('redirectLoginGoogle');
Route::get('auth/google/callback', [AuthController::class, 'handleLoginOrRegisterWithGoogle'])->name('handleLoginGoogle');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');



// middleware auth
Route::middleware(['auth'])->group(function () {

    // middleware only admin
    Route::middleware(['admin'])->group(function () {

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // prefix user manager
        Route::prefix('user-manager')->group(function () {
            Route::get('/', [UserManagerController::class, 'index'])->name('user-manager');
            Route::post('/', [UserManagerController::class, 'store'])->name('user-manager-store');
            Route::post('/{id}', [UserManagerController::class, 'update'])->name('user-manager-update');
            Route::post('update-password/{id}', [UserManagerController::class, 'updatePassword'])->name('user-manager-update-password');
            Route::post('delete/{id}', [UserManagerController::class, 'destroy'])->name('user-manager-delete');
        });

        // prefix bookings manager
        Route::prefix('booking-manager')->group(function () {
            Route::get('/', [BookingController::class, 'index'])->name('booking-manager');
            Route::post('update-status/{id}', [BookingController::class, 'updateBookStatus'])->name('booking-manager-update-status');
            Route::get('reschedule/{id}', [BookingController::class, 'reschedule'])->name('booking-manager-reschedule');
            Route::post('reschedule/{id}', [BookingController::class, 'UpdateReschedule'])->name('booking-manager-update-reschedule');
        });

        // prefix invoice manager
        Route::prefix('invoice-manager')->group(function () {
            Route::get('/', [InvoiceController::class, 'index'])->name('invoice-manager');
        });

        // prefix product manager
        Route::prefix('product-manager')->group(function () {
            Route::get('/product-main', [ProductController::class, 'indexProductMain'])->name('product-manager-product-main');
            Route::get('/product-main-add', [ProductController::class, 'addProductMain'])->name('product-manager-product-main-add');
            Route::post('/product-main-add-store', [ProductController::class, 'createProductMain'])->name('product-manager-product-main-add-store');
            Route::post('/product-main-update-status/{id}', [ProductController::class, 'updateStatusProductMain'])->name('product-manager-product-main-update-status');
            Route::get('/product-main-edit/{id}', [ProductController::class, 'editProductMain'])->name('product-manager-product-main-edit');
            Route::put('/product-main-edit-update/{id}', [ProductController::class, 'updateProductMain'])->name('product-manager-product-main-edit-update');

            Route::get('/product-additional', [ProductController::class, 'indexProductAddtional'])->name('product-manager-product-addtional');
            Route::get('/product-additional-add', [ProductController::class, 'addProducAddtional'])->name('product-manager-product-additional-add');
            Route::post('/product-additional-add-store', [ProductController::class, 'createProductAddtional'])->name('product-manager-product-additional-add-store');
            Route::post('/product-additional-update-status/{id}', [ProductController::class, 'updateStatusProductAdditional'])->name('product-manager-product-additional-update-status');
            Route::get('/product-additional-edit/{id}', [ProductController::class, 'editProductAdditional'])->name('product-manager-product-additional-edit');
            Route::put('/product-additional-edit-update/{id}', [ProductController::class, 'updateProductAdditional'])->name('product-manager-product-additional-edit-update');

            Route::get('/product-background', [ProductController::class, 'indexProductBackground'])->name('product-manager-product-background');
            Route::get('/product-background-add', [ProductController::class, 'addProducBackground'])->name('product-manager-product-background-add');
            Route::post('/product-background-add-store', [ProductController::class, 'createProductBackground'])->name('product-manager-product-background-add-store');
            Route::post('/product-background-update-status/{id}', [ProductController::class, 'updateStatusProductBackground'])->name('product-manager-product-background-update-status');
            Route::get('/product-background-edit/{id}', [ProductController::class, 'editProductBackround'])->name('product-manager-product-background-edit');
            Route::put('/product-background-edit-update/{id}', [ProductController::class, 'updateProductBackground'])->name('product-manager-product-background-edit-update');

            Route::get('/product-display', [ProductController::class, 'indexProductDisplay'])->name('product-manager-product-display');
            Route::get('/product-display-add', [ProductController::class, 'addProductDisplay'])->name('product-manager-product-display-add');
            Route::post('/product-display-add-store', [ProductController::class, 'createProductDisplay'])->name('product-manager-product-display-add-store');
            Route::post('/product-display-update-status/{id}', [ProductController::class, 'updateStatusProductDisplay'])->name('product-manager-product-display-update-status');
            Route::get('/product-display-edit/{id}', [ProductController::class, 'editProductDisplay'])->name('product-manager-product-display-edit');
            Route::put('/product-display-edit-update/{id}', [ProductController::class, 'updateProductDisplay'])->name('product-manager-product-display-edit-update');
        });

        // prefix promo manager
        Route::prefix('promo-manager')->group(function () {
            Route::get('/', [PromoController::class, 'index'])->name('promo-manager');
            Route::post('/create', [PromoController::class, 'create'])->name('promo-create');
            Route::put('/update/status/{id}', [PromoController::class, 'updatePromoStatus'])->name('promo-update-status');
            Route::put('/update/{id}', [PromoController::class, 'updatePromo'])->name('promo-update');

        });
    });

    // middleware client
    Route::middleware(['client'])->group(function () {

        Route::get('payment-redirect', function () {
            return redirect()->route('client-booking');
        })->name('payment-redirect');

        Route::post('/book', [BookingController::class, 'store'])->name('book.store');
        Route::get('/book/check-date', [BookingController::class, 'checkDate'])->name('book.checkDate');
        Route::get('/book/check-time', [BookingController::class, 'checkTime'])->name('book.checkTime');
        Route::post('/promo/check/{code}', [PromoController::class, 'checkPromo'])->name('promo-check');


        Route::prefix('{email}')->group(function () {
            Route::get('/book-preview/{package}', [BookingController::class, 'bookPreview'])->name('book-preview');
            Route::get('/', [ClientDashboardController::class, 'index'])->name('client-dashboard');
            Route::post('booking/{id}', [ClientDashboardController::class, 'update'])->name('account-client-update');
            Route::get('/booking', [ClientDashboardController::class, 'booking'])->name('client-booking');
            Route::get('/invoice', [ClientDashboardController::class, 'invoice'])->name('client-invoice');
        });

        Route::prefix('{email}')->group(function () {
            Route::post('/payment', [InvoiceController::class, 'create'])->name('payment');
        });

    });
});
