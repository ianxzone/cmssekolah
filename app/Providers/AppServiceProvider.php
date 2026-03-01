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

    public function boot(): void
    {
        $settings = \Cache::remember('site_settings', 3600, function () {
            return \App\Models\Setting::pluck('value', 'key')->toArray();
        });

        $activeTheme = $settings['active_theme'] ?? 'default';
        \Illuminate\Support\Facades\View::addNamespace('theme', resource_path('views/themes/' . $activeTheme));

        \Illuminate\Support\Facades\View::composer('*', function ($view) use ($settings) {
            $view->with('settings', $settings);
        });
    }

}
