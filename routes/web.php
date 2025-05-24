<?php

use App\Components\CacheKey;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/test-cache', function () {
//     $value = Cache::remember('test_key', now()->addMinutes(5), function () {
//         return now();
//     });


//     return view('time', compact('value'));
// });

Route::get('/api/categories', function () {
    return Cache::remember(CacheKey::categories(), now()->addHours(1), function () {
        return Category::where('is_active', true)
            ->select(['id', 'name', 'slug', 'description'])
            ->get();
    });
});
