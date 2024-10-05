<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserManagerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ClientDashboardController;
use App\Models\Invoice;
use App\Http\Controllers\ProductController;
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
        $Invoice = Invoice::with(['users'])->where('invoice_id', $request->order_id)->first();

        return redirect()->route('client-invoice', ['email' => $Invoice->users->email])->with('success', "Invoice " . $request->order_id . " berhasil melakukan pembayaran!");
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
            // Route::get('/product', [ProductController::class, 'indexProduct'])->name('product-manager-product');
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
