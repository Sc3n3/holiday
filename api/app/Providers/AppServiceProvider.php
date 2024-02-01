<?php

namespace App\Providers;

use App\Contracts\HolidayService;
use App\Services\OpenHolidays\Client;
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
        $this->app->singleton(HolidayService::class, function () {
            return new Client();
        });
    }
}
