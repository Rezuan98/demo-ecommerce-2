<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\SiteSetting;
use App\Models\Gtm;
use App\Http\View\Composers\GtmComposer;


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

// Share GTM data with specific views
        View::composer(['frontend.master.master'], function ($view) {
            $gtmData = Gtm::first();
            $view->with('gtmData', $gtmData);
        });

        View::composer('*', function ($view) {
            $settings = SiteSetting::first() ?? new SiteSetting();
            $view->with('settings', $settings);
        });
    }
}
