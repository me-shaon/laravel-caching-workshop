<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        $event = Event::factory()->create();
        $tickets = fake()->numberBetween(1, 5);

        return [
            'event_id' => $event->id,
            'user_email' => 'test@gmail.com',
            'number_of_tickets' => $tickets,
            'total_amount' => $event->ticket_price * $tickets,
            'status' => fake()->randomElement(['pending', 'confirmed', 'cancelled']),
        ];
    }
}