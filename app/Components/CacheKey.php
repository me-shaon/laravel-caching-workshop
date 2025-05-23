<?php

namespace App\Components;

class CacheKey
{
    public static function topArticles(): string
    {
        return 'top-articles';
    }

    public static function viewedArticles($sessionId): string
    {
        return 'viewed-articles-' . $sessionId;
    }
}