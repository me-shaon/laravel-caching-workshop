<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('cache:top-articles')
    ->daily()
    ->name('Cache Top Articles')
    ->withoutOverlapping();
