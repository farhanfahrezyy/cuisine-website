@extends('layouts.layoutpages')
@section('title', 'Articles')
@section('content')
<div class="uk-section uk-section-default uk-padding-small">
    <div class="uk-container">
        <h2 class="uk-heading-bullet uk-margin-medium-bottom uk-text-medium">Related Articles</h2>

        <div class="uk-grid uk-grid-small uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-3@m" data-uk-grid>
            @forelse($articles as $article)
                <div>
                    <div class="uk-card uk-card-small uk-card-default uk-card-hover uk-box-shadow-small uk-border-rounded uk-overflow-hidden">
                        <div class="uk-card-media-top">
                            <img
                                src="{{ $article->image ? asset('storage/' . $article->image) : asset('images/default.png') }}"
                                alt="{{ $article->title }}"
                                class="uk-width-1-1 uk-height-small object-cover"
                            >
                        </div>
                        <div class="uk-card-body uk-padding-small">
                            <h3 class="uk-margin-remove-bottom uk-text-bold uk-text-small">
                                {{ $article->title }}
                            </h3>
                            <p class="uk-text-muted uk-text-small uk-margin-small-top uk-margin-small-bottom">
                                {{ Str::limit(strip_tags($article->detail), 60) }}
                            </p>
                            <div class="uk-flex uk-flex-between uk-flex-middle uk-margin-small-top">
                                <a href="{{ route('articles.show', $article->id) }}" class="uk-text-primary uk-text-small">
                                    Read more
                                </a>
                                <span class="uk-text-meta uk-text-xsmall">
                                    {{ $article->news_date->format('M d, Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="uk-width-1-1 uk-text-center">
                    <div class="uk-alert">
                        <p>No articles found.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="uk-margin-medium-top">
            {{ $articles->links() }}
        </div>
    </div>
</div>
@endsection
