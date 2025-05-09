<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}">CUISINE</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard') }}">CSN</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard Admin</li>

            <li class="nav-item {{ $type_menu === 'dashboard' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-fire"></i> <span>Dashboard</span>
                </a>
            </li>

            <li class="{{ $type_menu === 'recipe' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.recipes.index') }}">
                    <i class="fas fa-utensils"></i> <span>Recipes</span>
                </a>
            </li>

            <li class="{{ $type_menu === 'article' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.articles.index') }}">
                    <i class="fas fa-newspaper"></i> <span>Articles</span>
                </a>
            </li>

            <li class="{{ $type_menu === 'payment' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.payments.index') }}">
                    <i class="fas fa-money-bill"></i> <span>Payments</span>
                </a>
            </li>

            <li class="{{ $type_menu === 'review' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.reviews.index') }}">
                    <i class="fas fa-star"></i> <span>Reviews</span>
                </a>
            </li>

            {{-- <li class="{{ $type_menu === 'user' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.users.index') }}">
                    <i class="fas fa-users"></i> <span>Users</span>
                </a>
            </li> --}}





            {{-- <li class="">

                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-fire"></i> <span>Dashboard</span>
                </a>
                <a class="nav-link" href="{{ route('admin.recipes.index') }}">
                    <i class="fas fa-utensils"></i> <span>Recipe</span>
                </a>
                <a class="nav-link" href="{{ route('admin.articles.index') }}">
                    <i class="fas fa-newspaper"></i> <span>Article</span>
                </a>
                <a class="nav-link" href="{{ route('admin.payments.index') }}">
                    <i class="fas fa-money-bill"></i> <span>Payment</span>
                </a>
                {{-- <a class="nav-link" href="{{ route('admin.users.index') }}">
                    <i class="fas fa-users"></i> <span>Users</span>
                    </a> --}}

            </li>
            {{-- <li class="{{ $type_menu === 'review' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.products.reviews') }}">
                    <i class="fas fa-star"></i> <span>Review</span>
                </a>
            </li> --}}
            {{-- nav-item {{ $type_menu === 'dashboard' ? 'active' : '' }} --}}

        </ul>
    </aside>
</div>
