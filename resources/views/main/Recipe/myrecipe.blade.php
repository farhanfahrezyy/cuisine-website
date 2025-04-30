@extends('layouts.layoutpages')

@section('title', 'My Purchased Recipes')

@section('content')
    <div class="uk-container">
        <div class="uk-border-rounded-large uk-background-top-center uk-background-cover
        uk-background-norepeat uk-light uk-inline uk-overflow-hidden uk-width-1-1"
            style="background-image: url('{{ asset('images/food.jpg') }}');">
            <div class="uk-position-cover uk-header-overlay"></div>
            <div class="uk-position-relative" data-uk-grid>
                <div class="uk-width-1-2@m uk-flex uk-flex-middle">
                    <div class="uk-padding-large uk-padding-remove-right">
                        <h1 class="uk-heading-small uk-margin-remove-top">My Purchased Recipes</h1>
                        <p class="uk-text-secondary">
                            You have purchased {{ $purchaseCount }} {{ Str::plural('recipe', $purchaseCount) }} in total.
                            Explore your collection below.
                        </p>

                        <a class="uk-text-secondary uk-text-600 uk-text-small hvr-forward"
                            href="{{ route('home') }}">Browse more recipes →</a>
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
                                    <li><a href="{{ route('recipes.cuisine', 'korea') }}">Korean Food</a></li>
                                    <li><a href="{{ route('recipes.cuisine', 'indonesia') }}">Indonesian Food</a>
                                    </li>
                                    <li><a href="{{ route('recipes.cuisine', 'jepang') }}">Japanese Food</a></li>
                                    <li><a href="{{ route('recipes.cuisine', 'india') }}">Indian Food</a></li>
                                    <li><a href="{{ route('recipes.cuisine', 'western') }}">Western Food</a></li>
                                    <li><a href="{{ route('recipes.cuisine', 'italia') }}">Italian Food</a></li>
                                </ul>
                            </li>
                            <li class="uk-parent">
                                <a href="#">Premium Recipes</a>
                                <ul class="uk-nav-sub">
                                    <li><a href="{{ route('recipes.premium', 'korea') }}">Korean Food</a></li>
                                    <li><a href="{{ route('recipes.premium', 'Indonesia') }}">Indonesian Food</a>
                                    </li>
                                    <li><a href="{{ route('recipes.premium', 'jepang') }}">Japanese Food</a></li>
                                    <li><a href="{{ route('recipes.premium', 'india') }}">Indian Food</a></li>
                                    <li><a href="{{ route('recipes.premium', 'western') }}">Western Food</a></li>
                                    <li><a href="{{ route('recipes.premium', 'italia') }}">Italian Food</a></li>
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

                    <div class="uk-child-width-1-2 uk-child-width-1-3@s" data-uk-grid>
                        @if (isset($searchQuery) && $recipes->isEmpty())
                            <div class="text-center my-5 w-full">
                                <h3>Tidak ada pencarian yang sesuai</h3>
                                <a href="{{ route('home') }}" class="btn btn-primary mt-3">Kembali</a>
                            </div>
                        @elseif ($recipes->isEmpty())
                            <div class="text-center my-5 w-full">
                                <h3>Anda belum memiliki resep yang dibeli</h3>
                                <p>Jelajahi koleksi resep kami dan temukan resep yang ingin Anda coba</p>
                                <a href="{{ route('home') }}" class="btn btn-primary mt-3">Jelajahi Resep</a>
                            </div>
                        @else
                            @foreach ($recipes as $recipe)
                                <div class="group">
                                    <div
                                        class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200">
                                        <!-- Card Media Top -->
                                        <div class="relative aspect-video overflow-hidden rounded-t-xl">
                                            <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->name }}"
                                                class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-300">
                                        </div>
                                        <!-- Card Body -->
                                        <div class="p-4 md:p-5">
                                            <!-- Recipe Name -->
                                            <h3 class="font-semibold text-lg mb-2 truncate">
                                                {{ Str::limit($recipe->name, 30) }}
                                            </h3>

                                            <!-- Rating and Price Row -->
                                            <div class="flex justify-between items-center mb-3">
                                                <div class="flex items-center space-x-1">
                                                    <span class="text-yellow-400"
                                                        data-uk-icon="icon: star; ratio: 0.8"></span>
                                                    <span class="font-medium text-sm">
                                                        {{ sprintf('%.2f', $recipe->reviews->avg('rating')) }}
                                                        <span
                                                            class="text-gray-500 ml-1">({{ $recipe->reviews->count() }})</span>
                                                    </span>
                                                </div>

                                                <span class="font-semibold text-gray-500">
                                                    Sudah Dibeli
                                                </span>
                                            </div>

                                            <!-- Category and Action -->
                                            <div class="flex flex-wrap sm:flex-nowrap justify-between items-center gap-2">
                                                <span class="text-gray-500 text-sm truncate">
                                                    {{ $recipe->country }}
                                                </span>

                                                <a href="{{ route('recipes.show', ['id' => $recipe->id]) }}"
                                                    class="uk-text-primary font-s, mediwhitespace-nowrap">
                                                    Lihat Resep →
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Pagination -->
                @if(!$recipes->isEmpty())
                    <div class="uk-margin-large-top uk-text-small uk-width-1-1">
                        {{ $recipes->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
