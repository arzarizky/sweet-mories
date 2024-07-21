<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserManagerController;
use App\Http\Controllers\BookingController;



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

// prefix login
Route::prefix('/')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('auth.login');
    Route::post('/', [AuthController::class, 'login'])->name('auth.login-post');
});




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
            // Route::post('/', [UserManagerController::class, 'store'])->name('booking-manager-store');
            // Route::post('/{id}', [UserManagerController::class, 'update'])->name('booking-manager-update');
            // Route::post('update-password/{id}', [UserManagerController::class, 'updatePassword'])->name('booking-manager-update-password');
            // Route::post('delete/{id}', [UserManagerController::class, 'destroy'])->name('booking-manager-delete');
        });
    });


    // logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
