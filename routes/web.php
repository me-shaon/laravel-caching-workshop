<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-cache', function () {
    $value = Cache::remember('test_key', now()->addMinutes(5), function () {
        return now();
    });


    return view('time', compact('value'));
});
