<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserManagerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ClientDashboardController;
use App\Http\Controllers\PaymentController;
use App\Models\Invoice;
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
    Route::get("/", function () {
        return view('pages.landing-page.home');
    })->name('home-landing');

    Route::get("/portfolio", function () {
        return view('pages.landing-page.portfolio');
    })->name('portfolio-landing');

    Route::get("/gallery", function () {
        return view('pages.landing-page.gallery');
    })->name('gallery-landing');

    Route::get("/pricelist", function () {
        return view('pages.landing-page.pricelist');
    })->name('pricelist-landing');

    // Route::get("/exhibitions", function(){
    //     return view('pages.landing-page.exhibitions');
    // })->name('exhibitions-landing');

    Route::get("/book-now", function () {
        return view('pages.landing-page.book-now');
    })->name('book-now-landing');

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
        });

        // prefix invoice manager
        Route::prefix('invoice-manager')->group(function () {
            Route::get('/', [InvoiceController::class, 'index'])->name('invoice-manager');
        });
    });

    // middleware client
    Route::middleware(['client'])->group(function () {

        Route::get('payment-redirect', function () {
            return redirect()->route('client-invoice');
        })->name('payment-redirect');

        Route::post('/book', [BookingController::class, 'store'])->name('book.store');
        Route::get('/book/check-date', [BookingController::class, 'checkDate'])->name('book.checkDate');
        Route::get('/book/check-time', [BookingController::class, 'checkTime'])->name('book.checkTime');

        Route::prefix('{email}')->group(function () {
            Route::get('/book-preview', [BookingController::class, 'bookPreview'])->name('book-preview');
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
