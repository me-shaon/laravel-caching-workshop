<?php 

namespace App\Components;

class CacheKey 
{
    public static function usersCount(): string
    {
        return 'users-count';
    }
}
