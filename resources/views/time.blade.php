@extends('app')

@section('content')
    <div class="w-full min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500">
        <div class="text-center space-y-4">
            <h1 class="text-5xl font-extrabold text-white tracking-tight md:text-6xl lg:text-7xl">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-white to-gray-200">{{ $value }}</span>
            </h1>
        </div>
    </div>
@endsection
