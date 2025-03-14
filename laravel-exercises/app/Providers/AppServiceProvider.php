<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\TypeProduct;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer("header", function ($view) {
            $type_product = TypeProduct::all(); 
            $view->with("type_product", $type_product);
        });
    }
}
