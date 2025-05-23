<?php

namespace App\Http\Controllers;

use App\Components\CacheKey;
use App\Models\Event;
use App\Models\Booking;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('is_active', true)
            ->where('available_tickets', '>', 0)
            ->get();

        return view('events.index', compact('events'));
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function book(Request $request, Event $event)
    {
        $request->validate([
            'user_email' => ['required', 'email'],
            'number_of_tickets' => ['required', 'integer', 'min:1']
        ]);

        $lock = Cache::lock(CacheKey::bookingLock($event->id), 10);

        try {
            $lock->block(5);

            if ($request->number_of_tickets > $event->available_tickets) {
                return redirect()->route('events.show', $event)
                    ->with('error', 'Not enough tickets available!');
            }

            $event->available_tickets -= $request->number_of_tickets;
            $event->save();

            $event->bookings()->create([
                'user_id' => auth()->id(),
                'user_email' => $request->user_email,
                'number_of_tickets' => $request->number_of_tickets,
                'total_amount' => $event->ticket_price * $request->number_of_tickets
            ]);

            $lock->release();

            return redirect()->route('events.show', $event)
                ->with('success', 'Booking confirmed successfully!');

        } catch (LockTimeoutException $e) {
            return redirect()->route('events.show', $event)
                ->with('error', 'Server is busy, please try again!');
        }
    }
}