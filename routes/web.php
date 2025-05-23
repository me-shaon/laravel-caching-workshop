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


Route::get('/blog', function () {
    // Get paginated articles with caching
    $articles = Article::latest('published_at')
        ->paginate(10);

    return view('blog', compact('articles'));
});

Route::get('/api/top-articles', function () {
    // Get top 5 articles by views with caching
    $topArticles = Article::orderByDesc('view_count')
        ->take(5)
        ->get();

    return response()->json($topArticles);
});

// Route::get('/blog', function () {
//     // Get paginated articles with caching
//     $articles = Cache::remember('articles.page.' . request('page', 1), now()->addMinutes(10), function () {
//         return Article::latest('published_at')
//             ->paginate(10);
//     });

//     return view('blog', compact('articles'));
// });

// Route::get('/api/top-articles', function () {
//     $ttl = now()->addDay();
//     // Get top 20 articles by views with caching
//     $topArticles = Cache::remember(CacheKey::topArticles(), $ttl, function () {
//         return Article::orderByDesc('view_count')
//             ->take(5)
//             ->get();
//     });

//     return response()->json($topArticles);
// });



// Route::get('/api/top-articles', function () {
//     $ttl = now()->addDay();
//     // Get top 20 articles by views with caching
//     $topArticles = Cache::remember(CacheKey::topArticles(), $ttl, function () {
//         return Article::orderByDesc('view_count')
//             ->take(20)
//             ->get();
//     });

//     // Filter out the articles that the user has already viewed
//     $sessionId = session()->getId();
//     $viewedArticles = Cache::get(CacheKey::viewedArticles($sessionId), []);
//     $topArticles = $topArticles->filter(function ($article) use ($viewedArticles) {
//         return !in_array($article->id, $viewedArticles);
//     });

//     // If we have less than 5 unviewed articles, add back some viewed ones
//     // if ($topArticles->count() < 5) {
//     //     $needed = 5 - $topArticles->count();
//     //     $viewedTopArticles = $topArticles->whereIn('id', $viewedArticles)->take($needed);
//     //     $topArticles = $topArticles->concat($viewedTopArticles);
//     // }

//     $topArticles = $topArticles->slice(0, 5)->values();

//     return response()->json($topArticles);
// });

Route::get('/blog/{article}', function (Article $article) {
    // Increment view count
    $article->increment('view_count');
    
    // Add this article id in the cache for the current user using session id 
    $sessionId = session()->getId();
    $cacheKey = CacheKey::viewedArticles($sessionId);
    $viewedArticles = Cache::get($cacheKey, []);
    if (!in_array($article->id, $viewedArticles)) {
        $viewedArticles[] = $article->id;
        $ttl = now()->addDay();
        Cache::put($cacheKey, $viewedArticles, $ttl);
    }

    return view('article', compact('article'));
});
