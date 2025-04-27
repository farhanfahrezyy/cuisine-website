<nav class="uk-navbar-container uk-letter-spacing-small">
    <div class="uk-container">
        <div class="uk-position-z-index" data-uk-navbar>
            <!-- Logo and Main Navigation (Left Side) -->
            <div class="uk-navbar-left">
                <a class="uk-navbar-item uk-logo text-red-500" href="{{ route('home') }}">Cuisiné</a>
                <!-- Desktop Navigation -->
                <ul class="uk-navbar-nav uk-visible@m uk-margin-large-left">
                    <li class="uk-active"><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('articles') }}">Article</a></li>
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </div>

            <!-- Right Side Navigation -->
            <div class="uk-navbar-right">
                <!-- Search Icon -->
                {{-- <div class="uk-navbar-item">
                    <a class="uk-navbar-toggle" data-uk-search-icon href="#"></a>
                    <div class="uk-drop uk-background-default" data-uk-drop="mode: click; pos: left-center; offset: 0">
                        <form class="uk-search uk-search-navbar uk-width-1-1">
                            <input class="uk-search-input uk-text-demi-bold" type="search"
                                placeholder="Cari Resep yang kamu inginkan" autofocus>
                        </form>
                    </div>
                </div> --}}

                <!-- User Account Section (conditionally rendered) -->
                @if (Auth::check() && Auth::user()->role === 'user')
                    <div class="uk-navbar-item uk-visible@s">
                        <!-- User Dropdown Button -->
                        <div class="relative inline-block">
                            <button
                                class="flex items-center space-x-3 px-4 py-2.5 rounded-lg bg-white border border-gray-200 shadow-sm hover:bg-gray-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                                id="userDropdown" aria-haspopup="true" aria-expanded="false">
                                <!-- User Avatar -->
                                <div
                                    class="relative w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center text-white font-medium text-sm">
                                    <span>{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                                <!-- User Info -->
                                <div class="flex flex-col items-start">
                                    <span class="text-gray-800 text-sm font-medium">{{ Auth::user()->name }}</span>
                                    <span class="text-gray-500 text-xs">User Account</span>
                                </div>
                                <!-- Dropdown Arrow -->
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div class="absolute right-0 mt-2 w-48 origin-top-right bg-white border border-gray-200 divide-y divide-gray-100 rounded-lg shadow-lg opacity-0 invisible transform scale-95 transition-all duration-200 z-50"
                                id="dropdownMenu" aria-labelledby="userDropdown">
                                <!-- User Info Section -->
                                <div class="px-4 py-3 bg-gray-50 rounded-t-lg">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                </div>
                                <!-- Logout Section -->
                                <div class="py-1">
                                    <form action="{{ route('user.logout') }}" method="POST" class="w-full">
                                        @csrf
                                        <button type="submit"
                                            class="flex w-full items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                                </path>
                                            </svg>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                <div class="uk-navbar-item uk-visible@s">
                    <!-- Sign In Button -->
                    <a href="{{ route('user.login.form') }}" class="flex items-center px-5 py-2 mr-3 text-sm font-medium transition-all duration-200 rounded-full border border-gray-200 hover:border-red-300 hover:text-red-600 hover:bg-red-50">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Sign In
                    </a>

                    <!-- Sign Up Button -->
                    <a href="{{ route('user.register.form') }}" class="flex items-center px-5 py-2 text-sm font-medium text-white transition-all duration-200 rounded-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        Sign Up
                    </a>
                </div>

                <!-- Authentication redirect script -->
                {{-- <script>
                    @if (Auth::check() && Auth::user()->role === 'admin')
                        // If user is admin, display access denied message
                        alert("Akses ditolak. Halaman ini hanya untuk pengguna dengan role 'user'.");
                        window.location.href = "{{ route('admin.dashboard') }}"; // Redirect to admin dashboard
                    @else
                        // // If user is not logged in, redirect to login page
                        // window.location.href = "{{ route('home') }}";
                    @endif
                </script> --}}
                @endif

                <!-- Mobile Menu Toggle Button -->
                <a class="uk-navbar-toggle uk-hidden@m" href="#mobile-menu" data-uk-toggle><span
                        data-uk-navbar-toggle-icon></span></a>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Off-Canvas Menu -->
<div id="mobile-menu" uk-offcanvas="mode: push; overlay: true">
    <div class="uk-offcanvas-bar uk-flex uk-flex-column">
        <button class="uk-offcanvas-close" type="button" uk-close></button>

        <!-- Mobile Logo -->
        <div class="uk-margin-medium-bottom">
            <a class="uk-logo text-red-500" href="{{ route('home') }}">Cuisiné</a>
        </div>

        <!-- Mobile Navigation Links -->
        <ul class="uk-nav uk-nav-primary uk-nav-divider uk-margin-auto-vertical">
            <li class="uk-active"><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('articles') }}">Article</a></li>
            {{-- <li><a href="#">Search</a></li> --}}
            <li><a href="{{ route('about') }}">Contact</a></li>
        </ul>

        <!-- Mobile User Section -->
        @if (Auth::check() && Auth::user()->role === 'user')
            <div class="uk-margin-top uk-padding-small uk-background-muted uk-border-rounded">
                <div class="uk-flex uk-flex-middle">
                    <!-- User Avatar for Mobile -->
                    <div class="uk-width-auto">
                        <div
                            class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center text-white font-medium">
                            <span>{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                    </div>
                    <!-- User Info for Mobile -->
                    <div class="flex-grow ml-1 md:ml-2">
                        <h5 class="!text-black font-medium truncate text-sm md:text-base">{{ Auth::user()->name }}</h5>
                        <p class="text-gray-500 text-xs md:text-sm truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <!-- Mobile Logout Button -->
                <div class="uk-margin-small-top">
                    <form action="{{ route('user.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="uk-button uk-button-danger uk-button-small uk-width-1-1">
                            <span uk-icon="icon: sign-out"></span> Logout
                        </button>
                    </form>
                </div>
            </div>
        @else
        <div class="uk-margin-top uk-padding-small">
            <!-- Mobile Sign In Button -->
            <a href="{{ route('user.login.form') }}" class="flex items-center justify-center w-full px-5 py-2.5 mb-3 text-sm font-medium transition-all duration-200 rounded-full border border-gray-200 hover:border-red-300 hover:text-red-600 hover:bg-red-50">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
                Sign In
            </a>

            <!-- Mobile Sign Up Button -->
            <a href="{{ route('user.register.form') }}" class="flex items-center justify-center w-full px-5 py-2.5 text-sm font-medium text-white transition-all duration-200 rounded-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 shadow-sm hover:shadow-md">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                Sign Up
            </a>
        </div>
        @endif
    </div>
</div>

<script>
    // User dropdown functionality
    document.addEventListener('DOMContentLoaded', function() {
        const userDropdown = document.getElementById('userDropdown');
        const dropdownMenu = document.getElementById('dropdownMenu');

        if (userDropdown && dropdownMenu) {
            userDropdown.addEventListener('click', function() {
                if (dropdownMenu.classList.contains('invisible')) {
                    // Show dropdown
                    dropdownMenu.classList.remove('invisible', 'opacity-0', 'scale-95');
                    dropdownMenu.classList.add('visible', 'opacity-100', 'scale-100');
                } else {
                    // Hide dropdown
                    dropdownMenu.classList.remove('visible', 'opacity-100', 'scale-100');
                    dropdownMenu.classList.add('invisible', 'opacity-0', 'scale-95');
                }
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!userDropdown.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.classList.remove('visible', 'opacity-100', 'scale-100');
                    dropdownMenu.classList.add('invisible', 'opacity-0', 'scale-95');
                }
            });
        }
    });
</script>
