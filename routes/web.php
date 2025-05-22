<?php

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


Route::get('/users', function () {
    // Enable query logging
    DB::enableQueryLog();

    $count = User::count();

    // Get the number of queries executed
    $queryCount = count(DB::getQueryLog());
    
    return view('users', compact('count', 'queryCount'));
});

// Route::get('/users', function () {
//     // Enable query logging
//     DB::enableQueryLog();

//     $ttl = now()->addMinutes(30);
//     $count = Cache::remember('users-count', $ttl, function() {
//         return User::count();
//     });
    
//     // Get the number of queries executed
//     $queryCount = count(DB::getQueryLog());
    
//     return view('users', compact('count', 'queryCount'));
// });



// Question: Why it shows '3' queries first? 
// Check the Cache driver
