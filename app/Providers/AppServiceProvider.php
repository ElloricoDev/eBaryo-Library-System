<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Http;
use App\Helpers\WampSslHelper;
use GuzzleHttp\Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register custom Guzzle client for WAMP SSL issues
        if (app()->environment('local')) {
            $this->app->singleton('guzzle.client', function () {
                return new Client([
                    'verify' => false, // Disable SSL verification for WAMP
                    'timeout' => 30,
                    'connect_timeout' => 10,
                ]);
            });
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // WAMP-specific SSL configuration
        WampSslHelper::configureHttpClient();
        
        // Global HTTP client configuration for development
        if (app()->environment('local')) {
            Http::withOptions(['verify' => false]);
        }
        
        // Laravel default configurations
        \Illuminate\Support\Facades\Vite::prefetch(concurrency: 3);
        Schema::defaultStringLength(191);
    }
}
