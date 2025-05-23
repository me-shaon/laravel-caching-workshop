<?php

namespace App\Console\Commands;

use App\Components\CacheKey;
use App\Models\Article;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class UpdateArticleViewCounts extends Command
{
    protected $signature = 'articles:update-views';
    protected $description = 'Update article view counts in database from cache';

    public function handle()
    {
        $this->info('Updating article view counts from cache...');

        Article::chunk(100, function ($articles) {
            foreach ($articles as $article) {
                $viewCountKey = CacheKey::articleViews($article->id);
                $cachedViews = Cache::get($viewCountKey, 0);
                
                if ($cachedViews > 0) {
                    $article->increment('view_count', $cachedViews);
                    Cache::delete($viewCountKey);
                    $this->line("Updated article {$article->id} with {$cachedViews} views");
                }
            }
        });

        $this->info('Article view counts updated successfully!');
    }
}