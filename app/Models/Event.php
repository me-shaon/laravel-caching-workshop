<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'total_tickets',
        'available_tickets',
        'ticket_price',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function hasAvailableTickets(int $quantity = 1): bool
    {
        return $this->available_tickets >= $quantity;
    }

    public function decrementTickets(int $quantity = 1): void
    {
        $this->decrement('available_tickets', $quantity);
    }
}