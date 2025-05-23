@extends('app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-3">
                <h1 class="text-4xl font-bold text-gray-900 mb-8">Latest Articles</h1>
                
                <div class="space-y-8">
                    @foreach($articles as $article)
                        <article class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-2xl font-semibold text-gray-800 mb-4">
                                <a href="{{ url('/blog/' . $article->id) }}" class="hover:text-indigo-600 transition-colors">
                                    {{ $article->title }}
                                </a>
                            </h2>
                            <p class="text-gray-600 mb-4">
                                {{ Str::limit($article->content, 200) }}
                            </p>
                            <div class="flex justify-between items-center text-sm text-gray-500">
                                <span>{{ $article->published_at->diffForHumans() }}</span>
                                <span>{{ $article->view_count }} views</span>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $articles->links() }}
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Top Articles</h2>
                    <div id="topArticles" class="space-y-4">
                        <!-- Loading placeholder -->
                        <div class="animate-pulse">
                            <div class="h-4 bg-gray-200 rounded w-3/4 mb-2"></div>
                            <div class="h-4 bg-gray-200 rounded w-1/2 mb-4"></div>
                            <div class="h-4 bg-gray-200 rounded w-3/4 mb-2"></div>
                            <div class="h-4 bg-gray-200 rounded w-1/2 mb-4"></div>
                            <div class="h-4 bg-gray-200 rounded w-3/4 mb-2"></div>
                            <div class="h-4 bg-gray-200 rounded w-1/2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function loadTopArticles() {
        fetch('/api/top-articles')
            .then(response => response.json())
            .then(articles => {
                const container = document.getElementById('topArticles');
                container.innerHTML = articles.map(article => `
                    <div class="border-b border-gray-200 pb-4 last:border-0">
                        <h3 class="text-lg font-medium text-gray-800 mb-2">
                            <a href="/blog/${article.id}" class="hover:text-indigo-600 transition-colors">
                                ${article.title}
                            </a>
                        </h3>
                        <span class="text-sm text-gray-500">${article.view_count} views</span>
                    </div>
                `).join('');
            })
            .catch(error => {
                console.error('Error loading top articles:', error);
                const container = document.getElementById('topArticles');
                container.innerHTML = `
                    <div class="text-red-500 text-center py-4">
                        Failed to load top articles. Please try again later.
                    </div>
                `;
            });
    }

    // Load top articles when the page loads
    document.addEventListener('DOMContentLoaded', loadTopArticles);
</script>
@endpush