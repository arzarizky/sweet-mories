<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\UserManagerRepositoryInterface;
use App\Repositories\UserManagerRepository;
use App\Interfaces\BookingRepositoryInterface;
use App\Repositories\BookingRepository;
use App\Interfaces\InvoiceRepositoryInterface;
use App\Repositories\InvoiceRepository;
use App\Interfaces\ProductRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Interfaces\PromoRepositoryInterface;
use App\Repositories\PromoRepository;
use App\Interfaces\OutletRepositoryInterface;
use App\Repositories\OutletRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserManagerRepositoryInterface::class, UserManagerRepository::class);
        $this->app->bind(BookingRepositoryInterface::class, BookingRepository::class);
        $this->app->bind(InvoiceRepositoryInterface::class, InvoiceRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(PromoRepositoryInterface::class, PromoRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(OutletRepositoryInterface::class, OutletRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
