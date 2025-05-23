<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create some users
        User::factory(10)->create();

        // Create some events without any bookings
        Event::factory(5)->create();
    }
}
