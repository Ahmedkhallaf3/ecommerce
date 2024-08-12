<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Cart\CartRepository;
use App\Repositories\Cart\CartModelRepository;
use Illuminate\Http\Resources\Json\JsonResource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    //
    public function register(): void
    {


        $this->app->bind(CartRepository::class, function () {

            return new CartModelRepository();
        });


    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    

        JsonResource::withoutWrapping();

        Paginator::useBootstrap();
    }
}
