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

        // TODO
    }
}