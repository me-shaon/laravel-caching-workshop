<?php

namespace App\Components;

class CacheKey
{
    public static function reportReviewLock(string $reportId): string
    {
        return "report-review-lock-{$reportId}";
    }
}