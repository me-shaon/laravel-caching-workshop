<?php

namespace App\Console\Commands;

use App\Components\CacheKey;
use App\Models\Article;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class CacheTopArticles extends Command
{
    protected $signature = 'cache:top-articles';
    protected $description = 'Cache the top articles data';

    public function handle()
    {
        $this->info('Caching top articles...');

        $ttl = now()->addDay();
        $topArticles = Article::orderByDesc('view_count')
            ->take(20)
            ->get();

        Cache::put(CacheKey::topArticles(), $topArticles, $ttl);

        $this->info('Top articles cached successfully!');
    }
}