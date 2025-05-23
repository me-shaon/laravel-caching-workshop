@extends('app')

@section('content')
<div class="w-full max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Dashboard</h2>
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    Logout
                </button>
            </form>
        </div>
        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="text-lg font-semibold mb-2">User Information</h3>
            <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
            <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
        </div>
    </div>
</div>
@endsection