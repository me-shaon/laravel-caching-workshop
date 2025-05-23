<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
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


Route::get('/dashboard', function () {
    // Enable query logging
    DB::enableQueryLog();

    $usersCount = User::count();

    $productsCount = Product::count();

    $ordersCount = Order::count();

    // Get the number of queries executed
    $queryCount = count(DB::getQueryLog());
    
    return view('dashboard', compact('usersCount', 'productsCount', 'ordersCount', 'queryCount'));
});




// Route::get('/dashboard', function () {
//     // Enable query logging
//     DB::enableQueryLog();

//     $ttl = now()->addMinutes(30);

//     $usersCount = Cache::remember('users-count', $ttl, function() {
//         return User::count();
//     });

//     $productsCount = Cache::remember('products-count', $ttl, function() {
//         return Product::count();
//     });

//     $ordersCount = Cache::remember('orders-count', $ttl, function() {
//         return Order::count();
//     });
    
//     // Get the number of queries executed
//     $queryCount = count(DB::getQueryLog());
    
//     return view('dashboard', compact('usersCount', 'productsCount', 'ordersCount', 'queryCount'));
// });

