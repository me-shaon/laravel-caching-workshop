<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserReportFactory extends Factory
{
    public function definition(): array
    {
        $reviewStatus = fake()->boolean(70); // 70% chance of being reviewed

        return [
            'type' => fake()->randomElement(['spam', 'harassment', 'inappropriate', 'other']),
            'reason' => fake()->paragraph(),
            'reported_by' => User::factory(),
            'reported_user' => User::factory(),
            'reviewed_by' => $reviewStatus ? User::factory() : null,
            'review_action' => $reviewStatus ? fake()->randomElement(['warning', 'ban', 'no_action', 'under_review']) : null,
            'review_notes' => $reviewStatus ? fake()->text() : null,
            'reviewed_at' => $reviewStatus ? fake()->dateTimeBetween('-1 month') : null,
        ];
    }

    public function unreviewed(): static
    {
        return $this->state(fn (array $attributes) => [
            'reviewed_by' => null,
            'review_action' => null,
            'review_notes' => null,
            'reviewed_at' => null,
        ]);
    }

    public function reviewed(): static
    {
        return $this->state(fn (array $attributes) => [
            'reviewed_by' => User::factory(),
            'review_action' => fake()->randomElement(['warning', 'ban', 'no_action']),
            'review_notes' => fake()->text(),
            'reviewed_at' => fake()->dateTimeBetween('-1 month'),
        ]);
    }
}