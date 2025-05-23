@extends('app')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="container mx-auto px-4">
        <article class="bg-white rounded-lg shadow-lg p-8 max-w-4xl mx-auto">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $article->title }}</h1>
            
            <div class="flex items-center text-sm text-gray-500 mb-8">
                <span>Published {{ $article->published_at->diffForHumans() }}</span>
                <span class="mx-2">•</span>
                <span>{{ $article->view_count }} views</span>
            </div>

            <div class="prose prose-lg max-w-none">
                {!! nl2br(e($article->content)) !!}
            </div>
        </article>
    </div>
</div>
@endsection