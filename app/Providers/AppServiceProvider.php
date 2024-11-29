<?php

namespace App\Providers;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use App\Models\AppSetting;


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
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)
            ->by($request->ip())
            ->response( function (Request $request, array $headers) {
                return redirect()->back()->with('warning', 'We noticed unusual login activity. For security, please try again in 1 minutes.');
            });
        });

        view()->composer('*', function ($view) {
            $settings = AppSetting::pluck('value', 'key')->toArray();
            $view->with('settings', $settings);
        });
    }
}
