<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-cache', function () {
    $value = Cache::remember('test_key', now()->addMinutes(5), function () {
        return 'Generated at ' . now();
    });

    return "Value: {$value}";
});
