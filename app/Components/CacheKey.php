<?php

namespace App\Components;

class CacheKey
{
    public static function bookingLock(string $eventId): string
    {
        return 'booking-lock-' . $eventId;
    }
}