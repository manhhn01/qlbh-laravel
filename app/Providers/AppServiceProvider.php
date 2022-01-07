<?php

namespace App\Providers;

use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Coupon\CouponRepository;
use App\Repositories\Coupon\CouponRepositoryInterface;
use App\Repositories\Dashboard\DashboardRepository;
use App\Repositories\Dashboard\DashboardRepositoryInterface;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\ReceivedNote\ReceivedNoteRepository;
use App\Repositories\ReceivedNote\ReceivedNoteRepositoryInterface;
use App\Repositories\Supplier\SupplierRepository;
use App\Repositories\Supplier\SupplierRepositoryInterface;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->singleton(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->singleton(SupplierRepositoryInterface::class, SupplierRepository::class);
        $this->app->singleton(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->singleton(CouponRepositoryInterface::class, CouponRepository::class);
        $this->app->singleton(ReceivedNoteRepositoryInterface::class, ReceivedNoteRepository::class);
        $this->app->singleton(DashboardRepositoryInterface::class, DashboardRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap(); //sử dụng BS css cho paginator links
    }
}
