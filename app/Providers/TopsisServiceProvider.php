<?php

namespace App\Providers;

use App\Services\TopsisService;
use Illuminate\Support\ServiceProvider;

class TopsisServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(TopsisService::class, function ($app) {
            return new TopsisService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
