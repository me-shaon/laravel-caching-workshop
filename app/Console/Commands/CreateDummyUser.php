<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateDummyUser extends Command
{
    protected $signature = 'app:make-user';
    protected $description = 'Create a new dummy user';

    public function handle()
    {
        User::factory()->create();

        $this->info('Dummy user created successfully!');
    }
}