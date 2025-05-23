<?php

namespace App\Components;

class CacheKey
{
    public static function authUser($id)
    {
        return 'auth-user-'. $id;
    }
}