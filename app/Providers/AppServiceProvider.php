<?php

namespace App\Providers;

use App\GeneralSettings; 
use Illuminate\Support\Facades\View;
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
        try {
            $settings = GeneralSettings::first();
            View::share('settings', $settings);
        } catch (\Exception $e) {
          
            View::share('settings', null);
        }
    }
}
