@extends('layouts.layoutpages')

@section('title', 'Home')

@push('style')
    <style>
        /* Enhanced color palette */
        :root {
            --primary-color: #ff6b6b;
            --secondary-color: #4ecdc4;
            --accent-color: #ffd166;
            --text-dark: #2d3748;
            --text-light: #718096;
            --bg-light: #f7fafc;
        }

        /* Enhanced label styles */
        .uk-label-success {
            background-color: #32d296;
            border-radius: 20px;
            padding: 4px 12px;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(50, 210, 150, 0.3);
        }

        .uk-label-warning {
            background-color: #faa05a;
            border-radius: 20px;
            padding: 4px 12px;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(250, 160, 90, 0.3);
        }

        .uk-label-danger {
            background-color: #f0506e;
            border-radius: 20px;
            padding: 4px 12px;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(240, 80, 110, 0.3);
        }

        /* Hero section styling */
        .hero-section {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .uk-header-overlay {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.3) 100%);
        }

        /* Recipe card styling */
        .recipe-card {
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            height: 100%;
        }

        .recipe-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
        }

        .recipe-image-container {
            position: relative;
            overflow: hidden;
            height: 180px;
        }

        .recipe-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .recipe-card:hover .recipe-image {
            transform: scale(1.1);
        }

        .recipe-card-body {
            padding: 20px;
        }

        .recipe-title {
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--text-dark);
            font-size: 18px;
            line-height: 1.3;
        }

        .recipe-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            align-items: center;
        }

        .recipe-rating {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .recipe-price {
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 14px;
            background-color: #f7fafc;
        }

        .recipe-price.free {
            color: #32d296;
        }

        .recipe-price.premium {
            color: #f0506e;
        }

        .recipe-price.purchased {
            color: #718096;
        }

        .recipe-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
            margin-top: 15px;
        }

        .recipe-origin {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--text-light);
            font-size: 14px;
        }

        .recipe-link {
            color: var(--primary-color);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
            transition: gap 0.3s ease;
        }

        .recipe-link:hover {
            gap: 8px;
            text-decoration: none;
        }

        /* Search and filter styling */
        .search-bar {
            border-radius: 50px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            border: none;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }

        .search-bar:focus {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .uk-select-primary {
            border-radius: 50px;
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
            border: none;
            padding: 10px 25px;
            transition: all 0.3s ease;
        }

        .uk-select-primary:hover {
            background-color: #ff5252;
        }

        /* Sidebar styling */
        .sidebar-container {
            background-color: #fff;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        }

        .sidebar-title {
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary-color);
        }

        .uk-nav-default > li > a {
            padding: 10px 15px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .uk-nav-default > li > a:hover {
            background-color: #f5f7fa;
            color: var(--primary-color);
        }

        .uk-nav-sub li a {
            padding: 8px 15px 8px 20px;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .uk-nav-sub li a:hover {
            background-color: #f5f7fa;
            color: var(--primary-color);
        }

        /* Relevance badge positioning */
        .relevance-badge {
            position: absolute;
            bottom: 12px;
            left: 12px;
            z-index: 2;
        }

        /* Pagination styling */
        .uk-pagination > li > a {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 5px;
            transition: all 0.2s ease;
        }

        .uk-pagination > li.uk-active > a {
            background-color: var(--primary-color);
            color: white;
        }

        /* Empty state styling */
        .empty-state {
            padding: 40px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            text-align: center;
        }

        .empty-state-icon {
            font-size: 48px;
            color: var(--text-light);
            margin-bottom: 20px;
        }

        .empty-state-text {
            color: var(--text-dark);
            font-weight: 600;
            margin-bottom: 10px;
        }

        .empty-state-subtext {
            color: var(--text-light);
            margin-bottom: 20px;
        }
    </style>
@endpush

@section('content')
    <!-- Hero Section with Enhanced UI -->
    <div class="uk-container uk-margin-medium-top uk-margin-medium-bottom">
        <div class="hero-section uk-background-cover uk-background-center-center uk-light uk-position-relative"
            style="background-image: url('{{ asset('images/food.jpg') }}');">
            <div class="uk-position-cover uk-header-overlay"></div>
            <div class="uk-grid-collapse uk-position-relative" data-uk-grid>
                <div class="uk-width-1-2@m uk-flex uk-flex-middle">
                    <div class="uk-padding-large">
                        <h1 class="uk-heading-small uk-margin-remove-top uk-text-bold">Discover Delicious Recipes</h1>
                        <p class="uk-text-lead uk-margin-medium-bottom">Find your next favorite meal from thousands of recipes curated just for you.</p>
                        @if (Auth::check() && Auth::user()->role === 'user')
                            <a class="uk-button uk-button-primary uk-button-large uk-border-pill"
                                href="{{ route('user.recommendations.index') }}">
                                View Your Recommendations
                                <span uk-icon="icon: arrow-right; ratio: 1.2"></span>
                            </a>
                        @else
                            <a class="uk-button uk-button-primary uk-button-large uk-border-pill"
                                href="{{ route('user.register.form') }}">
                                Sign Up Today
                                <span uk-icon="icon: arrow-right; ratio: 1.2"></span>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="uk-width-expand@m"></div>
            </div>
        </div>
    </div>

    <div class="uk-section uk-section-default">
        <div class="uk-container">
            <div data-uk-grid>
                <!-- Sidebar Navigation -->
                <div class="uk-width-1-4@m">
                    <div class="sidebar-container" data-uk-sticky="offset: 100; bottom: true; media: @m;">
                        <h2 class="sidebar-title">Explore Recipes</h2>
                        <ul class="uk-nav-default uk-nav-parent-icon uk-nav-filter" data-uk-nav>
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
                                    <li><a href="{{ route('recipes.cuisine', 'indonesia') }}">Indonesian Food</a></li>
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
                                    <li><a href="{{ route('recipes.premium', 'Indonesia') }}">Indonesian Food</a></li>
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

                <!-- Main Content Area -->
                <div class="uk-width-expand@m">
                    <!-- Search and Sort Controls -->
                    <div class="uk-margin-medium-bottom" data-uk-grid>
                        <div class="uk-width-expand@m">
                            <form class="uk-search uk-search-default uk-width-1-1" action="{{ route('recipes.search') }}" method="GET">
                                <span data-uk-search-icon></span>
                                <input class="uk-search-input search-bar" name="query" type="search"
                                    placeholder="Search for recipes..." value="{{ request('query') }}">
                            </form>
                        </div>
                        <div class="uk-width-auto@m">
                            <select class="uk-select uk-select-primary" id="sort-select" onchange="window.location = this.value;">
                                <option value="{{ route('home', ['sort' => 'latest']) }}"
                                    {{ request('sort') == 'latest' ? 'selected' : '' }}>Sort: Latest</option>
                                <option value="{{ route('home', ['sort' => 'top-rated']) }}"
                                    {{ request('sort') == 'top-rated' ? 'selected' : '' }}>Sort: Top Rated</option>
                                <option value="{{ route('home', ['sort' => 'trending']) }}"
                                    {{ request('sort') == 'trending' ? 'selected' : '' }}>Sort: Trending</option>
                            </select>
                        </div>
                    </div>

                    <!-- Recipe Grid -->
                    <div class="uk-grid-medium uk-child-width-1-2 uk-child-width-1-3@m" data-uk-grid>
                        @php
                            // Filter recommendations to only include those with relevance_score > 0
                            $filteredRecommendations = $recommendations->filter(function ($recipe) {
                                return $recipe->relevance_score > 0;
                            });
                        @endphp

                        @forelse ($filteredRecommendations as $recipe)
                            <div>
                                <div class="recipe-card">
                                    <!-- Recipe Image -->
                                    <div class="recipe-image-container">
                                        <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->name }}" class="recipe-image">

                                        @php
                                            // Calculate relevance percentage for visual indicator
                                            $relevancePercentage = isset($maxPossibleScore) && $maxPossibleScore > 0
                                                ? min(100, round(($recipe->relevance_score / $maxPossibleScore) * 100))
                                                : 0;
                                        @endphp

                                        <!-- Relevance Badge -->
                                        <div class="relevance-badge">
                                            <span class="uk-label {{ $relevancePercentage > 70 ? 'uk-label-success' : ($relevancePercentage > 40 ? 'uk-label-warning' : 'uk-label-danger') }}">
                                                {{ $relevancePercentage }}% Cocok
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Recipe Content -->
                                    <div class="recipe-card-body">
                                        <h3 class="recipe-title uk-text-truncate" title="{{ $recipe->name }}">
                                            {{ Str::limit($recipe->name, 30) }}
                                        </h3>

                                        <!-- Rating and Price -->
                                        <div class="recipe-meta">
                                            <div class="recipe-rating">
                                                <span class="uk-text-warning" data-uk-icon="icon: star; ratio: 0.8"></span>
                                                <span>
                                                    {{ sprintf('%.2f', $recipe->reviews->avg('rating')) }}
                                                    <span class="uk-text-muted">({{ $recipe->reviews->count() }})</span>
                                                </span>
                                            </div>

                                            <span class="recipe-price
                                                @auth
                                                    {{ auth()->user()->hasPurchasedRecipe($recipe->id) ? 'purchased' : ($recipe->price == 0 ? 'free' : 'premium') }}
                                                @else
                                                    {{ $recipe->price == 0 ? 'free' : 'premium' }}
                                                @endauth
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

                                        <!-- Country and View Button -->
                                        <div class="recipe-footer">
                                            <span class="recipe-origin" title="{{ $recipe->country }}">
                                                <span data-uk-icon="icon: location; ratio: 0.8"></span>
                                                {{ $recipe->country ?: 'Indonesia' }}
                                            </span>

                                            <a href="{{ route('recipes.show', ['id' => $recipe->id]) }}" class="recipe-link">
                                                Lihat Resep
                                                <span data-uk-icon="icon: arrow-right; ratio: 0.8"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="uk-width-1-1">
                                <div class="empty-state">
                                    <div class="empty-state-icon" data-uk-icon="icon: search"></div>
                                    <h3 class="empty-state-text">Tidak ada resep yang cocok</h3>
                                    <p class="empty-state-subtext">Tidak ada resep yang cocok dengan preferensi Anda. Coba ubah preferensi Anda untuk hasil yang lebih baik.</p>
                                    <a href="{{ route('home') }}" class="uk-button uk-button-primary uk-border-pill">Lihat Semua Resep</a>
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
@endsection
