<?php

namespace App\Auth;

use App\Components\CacheKey;
use App\Models\User;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Support\Facades\Cache;

class CustomEloquentProvider extends EloquentUserProvider
{
    public function __construct(HasherContract $hasher)
    {
        parent::__construct($hasher, User::class);
    }

    public function retrieveById($identifier)
    {
        $cacheKey = CacheKey::authUser($identifier);
        $ttl = now()->addMinutes(30);
        
        return Cache::remember($cacheKey, $ttl, function () use ($identifier) {
            return User::find($identifier);
        });
    }
}