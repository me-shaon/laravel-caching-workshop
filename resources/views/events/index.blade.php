@extends('app')

@section('content')
    <div class="w-full min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-8">Upcoming Events</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($events as $event)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-500 hover:scale-105">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xl font-bold text-gray-900">{{ $event->name }}</h3>
                            </div>
                            
                            <p class="text-gray-600 mb-4 line-clamp-2">{{ $event->description }}</p>
                            
                            <div class="space-y-2 mb-6">
                                <div class="flex items-center text-gray-500">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>{{ $event->start_date->format('M d, Y') }}</span>
                                </div>
                                <div class="flex items-center text-gray-500">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>${{ number_format($event->ticket_price, 2) }}</span>
                                </div>
                                <div class="text-center">
                                    <span class="px-3 py-1 text-sm font-semibold text-green-800 bg-green-100 rounded-full">
                                        {{ $event->available_tickets }} left
                                    </span>
                                </div>
                            </div>

                            <div class="mt-4">
                                <a href="{{ route('events.show', $event) }}" 
                                   class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-300">
                                    <span>Book Now</span>
                                    <svg class="ml-2 -mr-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection