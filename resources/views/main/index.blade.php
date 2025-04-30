@extends('layouts.layoutpages')

@section('title', 'Home')

@push('styles')
    <style>
        .uk-nav-sub {
            overflow: hidden;
            max-height: 0;
            opacity: 0;
            transition: max-height 0.3s ease, opacity 0.3s ease;
        }

        /* Saat menu terbuka */
        .uk-open>.uk-nav-sub {
            max-height: 1000px;
            /* Nilai tinggi maksimum yang cukup besar */
            opacity: 1;
        }

        /* Ikon toggle */
        .uk-nav-parent-icon>li>a::after {
            content: '+';
            float: right;
            margin-left: 10px;
            transition: transform 0.3s ease;
        }

        .uk-nav-parent-icon>li.uk-open>a::after {
            content: '−';
            transform: rotate(90deg);
            /* Ubah rotasi menjadi 90 derajat */
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
                            infomediaries
                            negotiate sustainable strategic theme areas</p>

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
                            <li class="uk-parent">
                                <a href="#">All Recipes</a>
                                <ul class="uk-nav-sub">
                                    <li><a href="{{ route('home') }}">All Cuisine</a></li>
                                </ul>
                            </li>
                            <li class="uk-parent">
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
                                    <li><a href="{{ route('recipes.premium', 'indonesia') }}">Indonesian Food</a></li>
                                    <li><a href="{{ route('recipes.premium', 'jepang') }}">Japanese Food</a></li>
                                    <li><a href="{{ route('recipes.premium', 'india') }}">Indian Food</a></li>
                                    <li><a href="{{ route('recipes.premium', 'western') }}">Western Food</a></li>
                                    <li><a href="{{ route('recipes.premium', 'italia') }}">Italian Food</a></li>
                                </ul>
                            </li>
                            @if (Auth::check() && Auth::user()->role === 'user')
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
                            @endif
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

                                                <span
                                                    class="font-semibold
                                            @if (Auth::check() && Auth::user()->role === 'user') {{ auth()->user()->hasPurchasedRecipe($recipe->id) ? 'text-gray-500' : ($recipe->price == 0 ? 'text-green-600' : 'text-black-600') }}
                                            @else
                                                {{ $recipe->price == 0 ? 'text-green-600' : 'text-black-600' }} @endif
                                                ">
                                                    @if (Auth::check() && Auth::user()->role === 'user')
                                                        @if (auth()->user()->hasPurchasedRecipe($recipe->id))
                                                            Sudah Dibeli
                                                        @else
                                                            {{ $recipe->price == 0 ? 'Gratis' : 'Rp ' . number_format($recipe->price, 0, ',', '.') }}
                                                        @endif
                                                    @else
                                                        {{ $recipe->price == 0 ? 'Gratis' : 'Rp ' . number_format($recipe->price, 0, ',', '.') }}
                                                    @endif
                                                </span>
                                            </div>

                                            <!-- Category and Action -->
                                            <div class="flex flex-wrap sm:flex-nowrap justify-between items-center gap-2">
                                                <span class="text-gray-500 text-sm truncate">
                                                    {{ $recipe->country }}
                                                </span>

                                                @if (Auth::check() && Auth::user()->role === 'user')
                                                    <a href="{{ route('recipes.show', ['id' => $recipe->id]) }}"
                                                        class="uk-text-primary font-s, mediwhitespace-nowrap">
                                                        Lihat Resep →
                                                    </a>
                                                @elseif (!Auth::check())
                                                    <a href="{{ route('recipes.show', ['id' => $recipe->id]) }}"
                                                        class="uk-text-primary font-s, mediwhitespace-nowrap">
                                                        Lihat Resep →
                                                    </a>
                                                @else
                                                    <a href="{{ route('user.login.form') }}"
                                                        class="uk-text-primary font-s, mediwhitespace-nowrap">
                                                        Lihat Resep →
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <!-- Pagination -->

                        @endif
                    </div>
                    <div class="uk-margin-large-top uk-text-small">
                        {{ $recipes->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>

    <div class="uk-section uk-section-default">
        <div class="uk-container">
            <div data-uk-grid>
                <!-- Sticky Sidebar -->
                <div class="uk-width-1-4@m sticky-container">
                    <div data-uk-sticky="offset: 100; bottom: true; media: @m;">
                        {{-- <h2>Latest Articles</h2> --}}
                    </div>
                </div>

                <!-- Main Content -->
                <div class="uk-width-expand@m">
                    <div class="uk-flex uk-flex-between uk-flex-middle uk-margin-medium-bottom">
                        <div><strong>
                                <h6>Artikel Terbaru</h6>
                            </strong></div>
                        <a href="{{ route('articles') }}" class="uk-button uk-button-primary uk-border-pill mr-9">View
                            All
                            Articles</a>
                    </div>

                    <div class="uk-child-width-1-2 uk-child-width-1-3@s" data-uk-grid>
                        @forelse($articles->take(3) as $article)
                            <div>
                                <div
                                    class="bg-white uk-border-rounded-medium uk-box-shadow-small uk-box-shadow-hover-medium uk-overflow-hidden uk-height-1-1 uk-transition-toggle">
                                    <div class="uk-inline-clip uk-transition-toggle uk-width-1-1">
                                        <img src="{{ $article->image ? asset('storage/' . $article->image) : asset('images/default.png') }}"
                                            alt="{{ $article->title }}"
                                            class="uk-width-1-1 uk-height-small object-cover uk-transition-scale-up uk-transition-opaque">
                                    </div>

                                    <div class="uk-padding-small">
                                        <h3 class="uk-text-bold uk-margin-remove-bottom uk-text-truncate uk-text-small">
                                            {{ $article->title }}
                                        </h3>
                                        <p class="uk-text-muted uk-margin-small-top uk-margin-small-bottom uk-text-small">
                                            {{ Str::limit(strip_tags($article->detail), 60) }}
                                        </p>
                                        <div class="uk-flex uk-flex-between uk-flex-middle uk-margin-small-top">
                                            <a href="{{ route('articles.show', $article->id) }}"
                                                class="uk-text-primary uk-text-small">
                                                Lihat Artikel  →
                                            </a>
                                            <span class="uk-text-muted uk-text-xsmall">
                                                {{ $article->news_date->format('M d, Y') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="uk-width-1-1 uk-text-center uk-padding">
                                <p class="uk-text-muted">Tidak ada artikel yg ditemukan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const parents = document.querySelectorAll('.uk-parent'); // Pilih semua menu induk

            // Fungsi untuk menutup semua menu
            function closeAllMenus() {
                parents.forEach(parent => {
                    parent.classList.remove('uk-open');
                    const submenu = parent.querySelector('.uk-nav-sub');
                    submenu.style.maxHeight = '0px'; // Tutup dengan animasi
                });
            }

            parents.forEach(parent => {
                const link = parent.querySelector('a');
                const submenu = parent.querySelector('.uk-nav-sub');

                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    // Tutup semua menu terlebih dahulu
                    closeAllMenus();

                    // Buka menu yang diklik
                    parent.classList.toggle('uk-open');
                    if (parent.classList.contains('uk-open')) {
                        submenu.style.maxHeight = submenu.scrollHeight +
                        'px'; // Atur tinggi berdasarkan konten
                    } else {
                        submenu.style.maxHeight = '0px';
                    }
                });
            });

            // Otomatis buka menu aktif saat dimuat
            const currentPath = window.location.pathname;
            parents.forEach(parent => {
                const links = parent.querySelectorAll('.uk-nav-sub a');
                links.forEach(link => {
                    if (link.href.includes(currentPath)) {
                        closeAllMenus(); // Pastikan semua tertutup dulu
                        parent.classList.add('uk-open');
                        const submenu = parent.querySelector('.uk-nav-sub');
                        submenu.style.maxHeight = submenu.scrollHeight + 'px';
                    }
                });
            });
        });
    </script>
@endpush
