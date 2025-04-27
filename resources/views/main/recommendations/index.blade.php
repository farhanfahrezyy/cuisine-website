@extends('layouts.layoutpages')

@section('title', 'Home')

@push('style')
    <style>
        .uk-label-success {
            background-color: #32d296;
            /* Green color */
        }

        .uk-label-warning {
            background-color: #faa05a;
            /* Orange/Yellow color */
        }

        .uk-label-danger {
            background-color: #f0506e;
            /* Red color */
        }
    </style>
@endpush

@section('content')
    <div class="uk-container">
        <div class="uk-border-rounded-large uk-background-top-center uk-background-cover
    uk-background-norepeat uk-light uk-inline uk-overflow-hidden uk-width-1-1"
            style="background-image: url('{{ asset('images/food.jpg') }}');">
            <div class="uk-position-cover uk-header-overlay"></div>
            <div class="uk-position-relative" data-uk-grid>
                <div class="uk-width-1-2@m uk-flex uk-flex-middle">
                    <div class="uk-padding-large uk-padding-remove-right">
                        <h1 class="uk-heading-small uk-margin-remove-top">Choose from thousands of recipes</h1>
                        <p class="uk-text-secondary">Appropriately integrate technically sound value with scalable
                            infomediaries negotiate sustainable strategic theme areas</p>
                        @if (Auth::check() && Auth::user()->role === 'user')
                            <a class="uk-text-secondary uk-text-600 uk-text-small hvr-forward"
                                href="{{ route('user.recommendations.index') }}">Reccomendation for you
                                →</span></a>
                        @else
                            <a class="uk-text-secondary uk-text-600 uk-text-small hvr-forward"
                                href="{{ route('user.register.form') }}">Sign up
                                today → </span></a>
                        @endif
                    </div>
                </div>
                <div class="uk-width-expand@m">
                </div>
            </div>
        </div>
    </div>

    <div class="uk-section uk-section-default">
        <div class="uk-container">
            <div data-uk-grid>
                <div class="uk-width-1-4@m sticky-container">
                    <div data-uk-sticky="offset: 100; bottom: true; media: @m;">
                        <h2>Recipes</h2>
                        <ul class="uk-nav-default uk-nav-parent-icon uk-nav-filter uk-margin-medium-top" data-uk-nav>
                            <li class="uk-parent uk-open">


                                <a href="#">All Recipes</a>
                                <ul class="uk-nav-sub">
                                    <li><a href="{{ route('home') }}">All Cuisine</a></li>
                                </ul>
                            </li>

                                    <li class="uk-parent uk-open">


                                        <a href="#">Free Recipes</a>
                                        <ul class="uk-nav-sub">
                                            <li><a href="{{ route('recipes.cuisine', 'korean') }}">Korean Food</a></li>
                                            <li><a href="{{ route('recipes.cuisine', 'indonesia') }}">Indonesian Food</a>
                                            </li>
                                            <li><a href="{{ route('recipes.cuisine', 'japanese') }}">Japanese Food</a></li>
                                            <li><a href="{{ route('recipes.cuisine', 'indian') }}">Indian Food</a></li>
                                            <li><a href="{{ route('recipes.cuisine', 'western') }}">Western Food</a></li>
                                            <li><a href="{{ route('recipes.cuisine', 'italian') }}">Italian Food</a></li>
                                        </ul>
                                    </li>
                                    <li class="uk-parent">
                                        <a href="#">Premium Recipes</a>
                                        <ul class="uk-nav-sub">
                                            <li><a href="{{ route('recipes.premium', 'korean') }}">Korean Food</a></li>
                                            <li><a href="{{ route('recipes.premium', 'Indonesia') }}">Indonesian Food</a>
                                            </li>
                                            <li><a href="{{ route('recipes.premium', 'japanese') }}">Japanese Food</a></li>
                                            <li><a href="{{ route('recipes.premium', 'indian') }}">Indian Food</a></li>
                                            <li><a href="{{ route('recipes.premium', 'western') }}">Western Food</a></li>
                                            <li><a href="{{ route('recipes.premium', 'italian') }}">Italian Food</a></li>
                                        </ul>
                                    </li>



                                @auth
                                    <li class="uk-parent">
                                        <a href="#">Special Recommendation</a>
                                        <ul class="uk-nav-sub">
                                            <li><a href="{{ route('user.recommendations.index') }}">Recommendation</a></li>
                                        </ul>
                                    </li>
                                    <li class="uk-parent">
                                        <a href="#">My Recipe</a>
                                        <ul class="uk-nav-sub">
                                            <li><a href="{{ route('user.myrecipes.index') }}">Your Recipe</a></li>
                                        </ul>
                                    </li>
                                @endauth

                        </ul>
                    </div>
                </div>
                <div class="uk-width-expand@m">
                    <div data-uk-grid>
                        <div class="uk-width-expand@m">
                            <form class="uk-search uk-search-default uk-width-1-1" action="{{ route('recipes.search') }}"
                                method="GET">
                                <span data-uk-search-icon></span>
                                <input class="uk-search-input uk-text-small uk-border-rounded uk-form-large" name="query"
                                    type="search" placeholder="Search for recipes..." value="{{ request('query') }}">
                            </form>
                        </div>
                        <div class="uk-width-1-3@m uk-text-right@m uk-light">
                            <select class="uk-select uk-select-light uk-width-auto uk-border-pill uk-select-primary"
                                id="sort-select" onchange="window.location = this.value;">
                                <option value="{{ route('home', ['sort' => 'latest']) }}"
                                    {{ request('sort') == 'latest' ? 'selected' : '' }}>Sort by: Latest</option>
                                <option value="{{ route('home', ['sort' => 'top-rated']) }}"
                                    {{ request('sort') == 'top-rated' ? 'selected' : '' }}>Sort by: Top Rated</option>
                                <option value="{{ route('home', ['sort' => 'trending']) }}"
                                    {{ request('sort') == 'trending' ? 'selected' : '' }}>Sort by: Trending</option>
                            </select>
                        </div>
                    </div>


                    <!-- Recipe Grid - Removed the duplicate div -->

                    <div class="uk-child-width-1-2 uk-child-width-1-3@s" data-uk-grid>
                        @php
                            // Filter recommendations to only include those with relevance_score > 0
                            $filteredRecommendations = $recommendations->filter(function ($recipe) {
                                return $recipe->relevance_score > 0;
                            });
                        @endphp

                        @forelse ($filteredRecommendations as $recipe)
                            <div class="group">
                                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200">
                                    {{-- Card Media Top --}}
                                    <div class="uk-card-media-top uk-position-relative">
                                        @php

                                            // Calculate relevance percentage for visual indicator
                                            $relevancePercentage =
                                                isset($maxPossibleScore) && $maxPossibleScore > 0
                                                    ? min(
                                                        100,
                                                        round(($recipe->relevance_score / $maxPossibleScore) * 100),
                                                    )
                                                    : 0;
                                        @endphp

                                        <div class="relative aspect-video overflow-hidden rounded-t-xl">
                                            <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->name }}"
                                                class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-300">
                                        </div>



                                        {{-- Relevance Badge --}}
                                        <div class="uk-position-bottom-left uk-position-small">
                                            <span
                                                class="uk-label {{ $relevancePercentage > 70 ? 'uk-label-success' : ($relevancePercentage > 40 ? 'uk-label-warning' : 'uk-label-danger') }}">
                                                {{ $relevancePercentage }}% Cocok
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Card Body --}}
                                    <div class="uk-card-body uk-padding-small">
                                        {{-- Recipe Name --}}
                                        <h3 class="uk-card-title uk-margin-remove uk-text-truncate"
                                            title="{{ $recipe->name }}">
                                            {{ Str::limit($recipe->name, 30) }}
                                        </h3>

                                        {{-- Rating and Price Row --}}
                                        <div class="uk-flex uk-flex-between uk-margin-small-top">
                                            <div class="flex items-center space-x-1">
                                                <span class="text-yellow-400" data-uk-icon="icon: star; ratio: 0.8"></span>
                                                <span class="font-medium text-sm">
                                                    {{ sprintf('%.2f', $recipe->reviews->avg('rating')) }}
                                                    <span
                                                        class="text-gray-500 ml-1">({{ $recipe->reviews->count() }})</span>
                                                </span>
                                            </div>

                                            <span
                                                class="font-semibold
                                            @auth
{{ auth()->user()->hasPurchasedRecipe($recipe->id) ? 'text-gray-500' : ($recipe->price == 0 ? 'text-green-600' : 'text-black-600') }}
                                            @else
                                                {{ $recipe->price == 0 ? 'text-green-600' : 'text-black-600' }} @endauth
                                        ">
                                                @auth
                                                    @if (auth()->user()->hasPurchasedRecipe($recipe->id))
                                                        Sudah Dibeli
                                                    @else
                                                        {{ $recipe->price == 0 ? 'Gratis' : 'Rp ' . number_format($recipe->price, 0, ',', '.') }}
                                                    @endif
                                                @else
                                                    {{ $recipe->price == 0 ? 'Gratis' : 'Rp ' . number_format($recipe->price, 0, ',', '.') }}
                                                @endauth
                                            </span>
                                        </div>

                                        {{-- Country/Origin and Action Button --}}
                                        <div class="uk-flex uk-flex-between uk-margin-small-top">
                                            <span class="uk-text-meta uk-text-truncate" title="{{ $recipe->country }}">
                                                <span data-uk-icon="icon: location; ratio: 0.8"></span>
                                                {{ $recipe->country ?: 'Indonesia' }}
                                            </span>

                                            <a href="{{ route('recipes.show', ['id' => $recipe->id]) }}"
                                                class="uk-button uk-button-text uk-text-primary">
                                                Lihat Resep
                                            </a>
                                        </div>
                                    </div>
                                </div>
                    </div>
                @empty
                    <div class="uk-width-1-1 uk-text-center uk-margin-large">
                        <div class="uk-alert uk-alert-warning">
                            <p>Tidak ada resep yang cocok dengan preferensi Anda. Coba ubah preferensi Anda untuk
                                hasil yang lebih baik.</p>
                        </div>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if (method_exists($filteredRecommendations, 'links') && count($filteredRecommendations) > 0)
                    <div class="uk-margin-large-top uk-text-center">
                        {{ $filteredRecommendations->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    </div>

    {{-- <div class="uk-section uk-section-default">
        <div class="uk-container">
            <div data-uk-grid>
                <div class="uk-width-expand">
                    <b>Article</b>
                </div>
                <div class="uk-width-1-3 uk-text-right uk-light">
                    <select class="uk-select uk-select-light uk-width-auto uk-border-pill uk-select-primary">
                        <option>Featured</option>
                        <option>Top Rated</option>
                        <option>Trending</option>
                    </select>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
