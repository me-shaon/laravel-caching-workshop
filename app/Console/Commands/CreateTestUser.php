<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateTestUser extends Command
{
    protected $signature = 'app:user-create';
    protected $description = 'Create a test user with email and password';

    public function handle()
    {
        $email = $this->ask('What is the user\'s email?');
        $password = $this->secret('What is the user\'s password?');

        $user = User::create([
            'name' => 'Test User',
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info("User created successfully:");
        $this->table(
            ['Name', 'Email'],
            [[$user->name, $user->email]]
        );
    }
}