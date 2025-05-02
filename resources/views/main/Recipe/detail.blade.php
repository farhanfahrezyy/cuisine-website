@extends('layouts.layoutpages')

@section('title', $recipe->name)

<style>
    .rating {
        display: flex;
        flex-direction: row-reverse; /* Change to row-reverse for proper rating behavior */
        justify-content: flex-end;
        gap: 4px;
    }

    .rating input {
        display: none;
    }

    .rating label {
        cursor: pointer;
        margin-right: 4px; /* Add spacing between stars */
    }

    .rating label svg {
        transition: color 0.2s ease;
    }

    /* These selectors work with row-reverse to fill stars from right to left when hovered */
    .rating input:checked ~ label svg {
        color: #FFD700;
    }

    .rating label:hover svg,
    .rating label:hover ~ label svg {
        color: #FFED85;
    }

    /* Ensure the stars display inline horizontally */
    .star-rating svg {
        width: 18px;
        height: 18px;
        display: inline-block;
    }
</style>

@section('content')
    <div class="uk-container">
        <div data-uk-grid>
            <div class="uk-width-1-2@s">
                <div class="uk-card uk-card-default uk-box-shadow-small uk-margin">
    <div class="uk-card-media-top">
        <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->name }}"
     class="uk-width-1-1 uk-border-rounded" style="height: 300px; object-fit: cover;">
    </div>
</div>
            </div>
            <div class="uk-width-expand@s
uk-flex uk-flex-middle">
                <div>
                    <h1 style="font-size: 2rem" class="uk-text-bold uk-margin-small-bottom">{{ $recipe->name }}</h1>
                    <p>{{ $recipe->detail }}</p>

                    <div class="uk-margin-medium-top uk-child-width-expand uk-text-center uk-grid-divider" data-uk-grid>
                        <div>
                            <span class="fa-solid fa-location-dot"></span>
                            <h5 class="uk-text-500 uk-margin-small-top uk-margin-remove-bottom">Negara</h5>
                            <span class="uk-text-small">{{ $recipe->country }}</span>
                        </div>
                        <div>
                            <span class="fa-solid fa-star"></span>
                            <h5 class="uk-text-500 uk-margin-small-top uk-margin-remove-bottom">Rating</h5>
                            <div class="flex items-center justify-center">
                                @php
                                    $avgRating = $recipe->reviews->avg('rating');
                                    $fullStars = floor($avgRating);
                                    $halfStar = $avgRating - $fullStars > 0.3 ? true : false;
                                @endphp

                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $fullStars)
                                        <svg class="w-4 h-4 text-yellow-300 ms-1" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                            <path
                                                d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                        </svg>
                                    @elseif ($i == $fullStars + 1 && $halfStar)
                                        <svg class="w-4 h-4 text-yellow-300 ms-1" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                            <!-- Half star implementation -->
                                            <defs>
                                                <linearGradient id="halfStarGradient" x1="0%" y1="0%"
                                                    x2="100%" y2="0%">
                                                    <stop offset="50%" style="stop-color:#FFD700" />
                                                    <stop offset="50%" style="stop-color:#e5e7eb" />
                                                </linearGradient>
                                            </defs>
                                            <path fill="url(#halfStarGradient)"
                                                d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 ms-1 text-gray-300" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                            <path
                                                d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                            <span class="uk-text-small">{{ sprintf('%.2f', $recipe->reviews->avg('rating')) }}</span>
                        </div>
                        <div>
                            <span class="fa-solid fa-pepper-hot"></span>
                            <h5 class="uk-text-500 uk-margin-small-top uk-margin-remove-bottom">Kepedasan</h5>
                            <span class="uk-text-small">
                                @if ($recipe->spiciness === 'low')
                                    Tidak Pedas
                                @elseif ($recipe->spiciness === 'medium')
                                    Sedang
                                @elseif ($recipe->spiciness === 'high')
                                    Pedas
                                @else
                                    {{ $recipe->spiciness ?? '-' }}
                                @endif
                            </span>
                        </div>
                    </div>

                    <hr>
                </div>
            </div>
        </div>
    </div>

    <!-- Bagian How to Make dan Ingredients -->
    <div class="uk-section uk-section-default">
        <div class="uk-container uk-container-small">
            <div class="uk-grid-large" data-uk-grid>
                @auth
                    <div class="uk-width-expand@m">
                        <div class="uk-article">
                            <h3 style="font-size: 1.4rem" class="uk-text-bold uk-text-small">Langkah Pembuatan</h3>

                            @php
                                $instructions = json_decode($recipe->instructions, true);
                            @endphp

                            @if ($instructions)
                                @foreach ($instructions as $index => $instruction)
                                    <div id="step-{{ $index + 1 }}" class="uk-grid-small uk-margin-medium-top" data-uk-grid>
                                        <div class="uk-width-auto">
                                            <a href="#" class="uk-step-icon" data-uk-icon="icon: check; ratio: 0.8"
                                                data-uk-toggle="target: #step-{{ $index + 1 }}; cls: uk-step-active"></a>
                                        </div>
                                        <div class="uk-width-expand">
                                            <h5 class="uk-step-title uk-text-500 uk-text-uppercase uk-text-primary"
                                                data-uk-leader="fill:—">
                                                {{ $index + 1 }}. Step
                                            </h5>
                                            <div class="uk-step-content">{{ $instruction }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="uk-width-1-3@m">
                        <h3 style="font-size: 1.4rem" class="uk-text-bold uk-text-small">Bahan - bahan</h3>

                        @php
                            $ingredients = json_decode($recipe->ingredients, true);
                        @endphp

                        <ul class="uk-list uk-list-large uk-list-divider uk-margin-medium-top">
                            @if ($ingredients)
                                @foreach ($ingredients as $ingredient)
                                    <li>{{ $ingredient }}</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                @else
                    <!-- Jika pengguna belum login -->
                    <div class="uk-width-1-1@m uk-text-center">
                        <p class="uk-text-large">Silahkan login terlebih dahulu.</p>
                        <a href="{{ route('user.login.form') }}"
                            class="uk-button uk-button-primary uk-button-large uk-margin-medium-top uk-margin-medium-bottom"
                            style="min-width: 200px;">
                            Login
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    @auth
        <div class="uk-section uk-section-muted">
            <div class="uk-container uk-container-small">
                <h3 class="uk-text-bold uk-margin-medium-bottom">Ulasan</h3>

                <!-- Display Reviews -->
                <div class="uk-margin-medium-bottom">
                    @if ($reviews->count() > 0)
                        @foreach ($reviews as $review)
                            <div
                                class="uk-comment uk-margin-medium-bottom uk-background-default uk-padding-small uk-border-rounded">
                                <header class="uk-comment-header uk-grid-medium uk-flex-middle" uk-grid>
                                    <div class="uk-width-auto">
                                        <img class="uk-comment-avatar uk-border-circle"
                                            src="{{ asset('img/avatar/avatar-1.png') }}"
                                            width="50" height="50" alt="{{ $review->user->name }}">
                                    </div>
                                    <div class="uk-width-expand">
                                        <h4 class="uk-comment-title uk-margin-remove">{{ $review->user->name }}</h4>
                                        <div class="uk-comment-meta">
                                            {{ $review->created_at->diffForHumans() }}
                                        </div>
                                        <div class="uk-margin-small-top">
                                            <div class="flex items-center">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <svg class="w-4 h-4 @if ($i <= $review->rating) text-yellow-300 @else text-gray-300 @endif ms-1"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        fill="currentColor" viewBox="0 0 22 20">
                                                        <path
                                                            d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                                    </svg>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </header>
                                <div class="uk-comment-body uk-margin-small-top">
                                    <p>{{ $review->comment }}</p>
                                </div>

                                {{-- @if (Auth::check() && (Auth::id() == $review->user_id || Auth::user()->isAdmin()))
                                    <div class="uk-text-right uk-margin-small-top">
                                        <form action="{{ route('recipe.reviews.destroy', $review->id) }}" method="POST"
                                            class="uk-display-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="uk-button uk-button-small uk-button-danger"
                                                onclick="return confirm('Are you sure you want to delete this review?')">
                                                <span uk-icon="trash"></span> Delete
                                            </button>
                                        </form>
                                    </div>
                                @endif --}}
                            </div>
                        @endforeach

                        {{ $reviews->links() }}
                    @else
                        <div class="uk-alert uk-alert-primary">
                            <p>Belum ada ulasan. Silahkan tambahkan ulasan kamu</p>
                        </div>
                    @endif
                </div>

                <!-- Add Review Form -->
                <div class="uk-margin-large-top">
                    <h4 class="uk-text-bold">Tambahkan Ulasan Kamu ♥️</h4>

                    @if (session('success'))
                        <div class="uk-alert uk-alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="uk-alert uk-alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('recipe.reviews.store', $recipe->id) }}" method="POST" class="uk-form-stacked">
                        @csrf
                        <div class="uk-margin">
                            <label class="uk-form-label">Rating</label>
                            <div class="uk-form-controls">
                                <div class="rating">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <input type="radio" id="star{{ $i }}" name="rating"
                                            value="{{ $i }}" required
                                            @if (old('rating') == $i) checked @endif />
                                        <label for="star{{ $i }}">
                                            <svg class="w-4 h-4 @if (old('rating') == $i) text-yellow-300 @else text-gray-300 @endif"
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                viewBox="0 0 22 20">
                                                <path
                                                    d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                            </svg>
                                        </label>
                                    @endfor
                                </div>
                            </div>
                        </div>

                        <div class="uk-margin">
                            <label class="uk-form-label" for="comment">Ulasan</label>
                            <div class="uk-form-controls">
                                <textarea class="uk-textarea @error('comment') uk-form-danger @enderror" id="comment" name="comment"
                                    rows="5" required placeholder="Share your experience with this recipe...">{{ old('comment') }}</textarea>
                                @error('comment')
                                    <span class="uk-text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="uk-margin">
                            <button type="submit" class="uk-button uk-button-primary">Submit Review</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endauth
@endsection

@push('scripts')
    <script>
         document.addEventListener('DOMContentLoaded', function() {
        const ratingInputs = document.querySelectorAll('.rating input');

        ratingInputs.forEach(input => {
            input.addEventListener('change', function() {
                // Reset all stars to gray
                document.querySelectorAll('.rating label svg').forEach(svg => {
                    svg.classList.remove('text-yellow-300');
                    svg.classList.add('text-gray-300');
                });

                // Set selected star and all stars before it to yellow
                const selectedValue = parseInt(this.value);

                document.querySelectorAll('.rating input').forEach(inp => {
                    const starValue = parseInt(inp.value);
                    const svg = inp.nextElementSibling.querySelector('svg');

                    if (starValue <= selectedValue) {
                        svg.classList.remove('text-gray-300');
                        svg.classList.add('text-yellow-300');
                    }
                });
            });
        });
    });
    </script>
@endpush
