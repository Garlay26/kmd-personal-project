<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Product;
use App\Models\Order;
use App\Models\State;
use App\Models\Township;
use App\Observers\ProductObserver;
use App\Observers\OrderObserver;
use App\Observers\StateObserver;
use App\Observers\TownshipObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        Product::observe(ProductObserver::class);
        Order::observe(OrderObserver::class);
        State::observe(StateObserver::class);
        Township::observe(TownshipObserver::class);
    }
}
