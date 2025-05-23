<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('cache:top-articles')
    ->daily()
    ->name('Cache Top Articles')
    ->withoutOverlapping();

Schedule::command('articles:update-views')
    ->hourly()
    ->name('Update Article View Counts')
    ->withoutOverlapping();
