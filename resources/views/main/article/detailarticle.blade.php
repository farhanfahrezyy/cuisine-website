@extends('layouts.layoutpages')

@section('title', $article->title)

@section('content')
<div class="container mx-auto px-4 md:px-8 lg:px-16 py-8">
    <!-- Article Header -->
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">
                {{ $article->title }}
            </h1>
            <div class="flex items-center text-gray-600 text-sm md:text-base mb-4">
                <span class="mr-4">Oleh Admin</span>
                <span class="mr-4">•</span>
                <span>Dipublikasikan pada {{ $article->news_date->format('d F Y') }}</span>
            </div>
        </div>

        <!-- Featured Image -->
        <div class="mb-8">
            <img
                src="{{ asset('storage/' . $article->image) }}"
                alt="{{ $article->title }}"
                class="w-full h-[400px] object-cover rounded-lg"
            >
        </div>

        <!-- Article Content with Formatted Paragraphs -->
        <div class="prose max-w-none">
            @if(isset($article->formatted_detail))
                {!! $article->formatted_detail !!}
            @else
                {!! $article->detail !!}
            @endif
        </div>

        <!-- Tags -->
        <div class="mt-8 mb-12">
            <div class="flex flex-wrap gap-2">
                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">{{ $article->title }}</span>
                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">Cuisine</span>
            </div>
        </div>

        <!-- Author Info -->
        {{-- <div class="border-t border-gray-200 pt-8 mb-12">
            <div class="flex items-center">
                <img
                    src="/api/placeholder/64/64"
                    alt="Author"
                    class="w-16 h-16 rounded-full mr-4"
                >
                <div>
                    <h3 class="font-bold text-lg mb-1">Admin</h3>
                    <p class="text-gray-600">Content Writer</p>
                </div>
            </div>
        </div> --}}

        <!-- Related Articles Section -->
        @if(isset($relatedArticles) && $relatedArticles->count() > 0)
        <div class="border-t border-gray-200 pt-8">
            <h2 class="text-2xl font-bold mb-6">Artikel Terkait</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($relatedArticles as $relatedArticle)
                <div class="flex flex-col bg-white rounded-lg overflow-hidden shadow-sm h-full">
                    <img
                        src="{{ asset('storage/' . $relatedArticle->image) }}"
                        alt="{{ $relatedArticle->title }}"
                        class="w-full h-40 object-cover"
                    >
                    <div class="p-3 flex flex-col flex-grow">
                        <h3 class="text-lg font-bold mb-2 line-clamp-2">
                            {{ $relatedArticle->title }}
                        </h3>
                        <p class="text-gray-600 text-sm mb-3 line-clamp-3">
                            {{ Str::limit(strip_tags($relatedArticle->detail), 80) }}
                        </p>
                        <div class="mt-auto">
                            <a href="{{ route('articles.show', $relatedArticle->id) }}" class="text-red-500 hover:underline text-sm">
                                Baca selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
