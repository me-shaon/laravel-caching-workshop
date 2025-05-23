<?php

use App\Components\CacheKey;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use App\Models\Article;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/test-cache', function () {
//     $value = Cache::remember('test_key', now()->addMinutes(5), function () {
//         return now();
//     });


//     return view('time', compact('value'));
// });


// Route::get('/blog', function () {
//     // Get paginated articles with caching
//     $articles = Article::latest('published_at')
//         ->paginate(10);

//     return view('blog', compact('articles'));
// });

// Route::get('/api/top-articles', function () {
//     // Get top 5 articles by views with caching
//     $topArticles = Article::orderByDesc('view_count')
//         ->take(5)
//         ->get();

//     return response()->json($topArticles);
// });

Route::get('/blog', function () {
    // Get paginated articles with caching
    $articles = Cache::remember('articles.page.' . request('page', 1), now()->addMinutes(10), function () {
        return Article::latest('published_at')
            ->paginate(10);
    });

    return view('blog', compact('articles'));
});

Route::get('/api/top-articles', function () {
    $ttl = now()->addDay();
    // Get top 5 articles by views with caching
    $topArticles = Cache::remember(CacheKey::topArticles(), $ttl, function () {
        return Article::orderByDesc('view_count')
            ->take(5)
            ->get();
    });

    return response()->json($topArticles);
});
