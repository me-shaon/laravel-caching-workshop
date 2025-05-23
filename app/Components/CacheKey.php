<?php 

namespace App\Components;

class CacheKey 
{
    public static function usersCount(): string
    {
        return 'users-count';
    }

    public static function productsCount(): string
    {
        return 'products-count';
    }

    public static function ordersCount(): string
    {
        return 'orders-count';
    }
}
