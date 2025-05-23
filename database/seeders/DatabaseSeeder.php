<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserReport;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create 10 random users
        User::factory(10)->create();

        UserReport::factory(15)->unreviewed()->create();
    }
}
