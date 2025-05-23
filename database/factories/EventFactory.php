<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $totalTickets = fake()->numberBetween(50, 200);
        $bookedTickets = fake()->numberBetween(0, $totalTickets);

        return [
            'name' => fake()->sentence(3),
            'description' => fake()->paragraphs(3, true),
            'start_date' => fake()->dateTimeBetween('now', '+2 months'),
            'end_date' => fake()->dateTimeBetween('+2 months', '+4 months'),
            'total_tickets' => $totalTickets,
            'available_tickets' => $totalTickets - $bookedTickets,
            'ticket_price' => fake()->randomFloat(2, 10, 200),
            'is_active' => fake()->boolean(80),
        ];
    }
}