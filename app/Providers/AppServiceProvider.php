<?php

namespace App\Providers;

use App\Auth\CustomEloquentProvider;
use Illuminate\Cache\Events\CacheHit;
use Illuminate\Cache\Events\CacheMissed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
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
        Event::listen(function (CacheHit $event) {
            Log::info('Cache HIT: ' . $event->key);
        });

        Event::listen(function (CacheMissed $event) {
            Log::info('Cache MISS: ' . $event->key);
        });

        // Auth::provider('eloquent', function () {
        //     return resolve(CustomEloquentProvider::class);
        // });
    }
}
