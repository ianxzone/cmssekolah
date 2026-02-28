<?php

namespace App\Providers;

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
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $settings = \Cache::remember('site_settings', 3600, function () {
                return \App\Models\Setting::pluck('value', 'key')->toArray();
            });
            $view->with('settings', $settings);
        });
    }
}
