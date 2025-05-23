<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'number_of_tickets' => ['required', 'integer', 'min:1']
        ]);

        

        return redirect()->route('events.show', $event)
            ->with('success', 'Booking confirmed successfully!');
    }
}