<?php

namespace App\Components;

class CacheKey
{
    public static function topArticles(): string
    {
        return 'top-articles';
    }
}