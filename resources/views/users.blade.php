@extends('app')

@section('content')
    <div class="w-full min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500">
        <div class="text-center space-y-8">
            <div class="bg-white rounded-xl p-6 shadow-xl">
                <div class="space-y-2">
                    <h2 class="text-2xl font-semibold text-slate-700">Total Users</h2>
                    <p class="text-4xl font-bold text-slate-900">{{ $count }}</p>
                </div>
            </div>

            <div class="pt-2">
                <p class="text-xl font-bold text-white">Queries executed: {{ $queryCount }}</p>
            </div>
        </div>
    </div>
@endsection
