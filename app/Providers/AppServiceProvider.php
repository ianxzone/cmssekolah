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
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
                \Illuminate\Support\Facades\View::share('settings', $settings);
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\View::share('settings', []);
        }
    }
}
