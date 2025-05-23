@extends('app')

@section('content')
    <div class="w-full min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-3xl font-bold text-gray-900">{{ $event->name }}</h2>
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold {{ $event->hasAvailableTickets() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $event->hasAvailableTickets() ? $event->available_tickets . ' tickets left' : 'Sold Out' }}
                        </span>
                    </div>
                    
                    <div class="prose prose-lg text-gray-500 mb-8">
                        {{ $event->description }}
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 text-sm">
                        <div class="flex items-center space-x-2 text-gray-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ $event->start_date->format('F j, Y') }} - {{ $event->end_date->format('F j, Y') }}</span>
                        </div>
                        <div class="flex items-center space-x-2 text-gray-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>${{ number_format($event->ticket_price, 2) }} per ticket</span>
                        </div>
                    </div>

                    @if($event->hasAvailableTickets())
                        <form action="{{ route('events.book', $event) }}" method="POST" class="space-y-6">
                            @csrf
                            <div>
                                <label for="user_email" class="block text-sm font-medium text-gray-700">Email address</label>
                                <div class="mt-2">
                                    <input type="email" name="user_email" id="user_email" 
                                           class="block w-full rounded-md border-2 border-gray-400 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-2 px-3"
                                           required>
                                </div>
                            </div>
                            <div>
                                <label for="number_of_tickets" class="block text-sm font-medium text-gray-700">How many tickets would you like?</label>
                                <div class="mt-2">
                                    <input type="number" name="number_of_tickets" id="number_of_tickets" 
                                           class="block w-full rounded-md border-2 border-gray-400 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-2 px-3"
                                           min="1" max="{{ $event->available_tickets }}" required>
                                </div>
                            </div>
                            <button type="submit" 
                                    class="w-full flex justify-center items-center px-4 py-3 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-300">
                                <span>Confirm Booking</span>
                                <svg class="ml-2 -mr-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </button>
                        </form>
                    @else
                        <div class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-red-100 mb-4">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                            <p class="text-xl font-semibold text-red-600">Sorry, this event is sold out!</p>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="mt-6 rounded-md bg-green-50 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mt-6 rounded-md bg-red-50 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection