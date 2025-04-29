@extends('layouts.app')

@section('title', 'Dashboard Admin')

@push('style')
    <!-- CSS Libraries -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Color Variables */
        :root {
            --primary: #4f46e5;
            --primary-dark: #3730a3;
            --secondary: #10b981;
            --secondary-dark: #059669;
            --accent: #f59e0b;
            --accent-dark: #d97706;
            --info: #3b82f6;
            --info-dark: #2563eb;
            --text-primary: #111827;
            --text-secondary: #6b7280;
            --bg-light: #f9fafb;
            --border-light: #e5e7eb;
            --success-light: #dcfce7;
            --success-dark: #16a34a;
        }

        /* Base Styles */
        body {
            background-color: var(--bg-light);
            color: var(--text-primary);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        /* Dashboard Header */
        .dashboard-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            padding: 1.5rem;
            border-radius: 0.75rem;
            margin-bottom: 2rem;
            color: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .dashboard-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .dashboard-header p {
            opacity: 0.9;
            font-size: 0.95rem;
        }

        .date-display {
            background: rgba(255, 255, 255, 0.15);
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            min-width: 120px;
        }

        /* Dashboard Cards */
        .dashboard-card {
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border: 1px solid var(--border-light);
            height: 100%;
        }

        .dashboard-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .card-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.75rem;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .card-icon.users {
            background: #e0e7ff;
            color: var(--primary);
        }

        .card-icon.revenue {
            background: #dcfce7;
            color: var(--secondary-dark);
        }

        .card-icon.premium {
            background: #fef3c7;
            color: var(--accent-dark);
        }

        .card-icon.recipes {
            background: #dbeafe;
            color: var(--info-dark);
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
            line-height: 1.2;
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
        }

        .stat-change {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            font-weight: 500;
        }

        .stat-change.positive {
            background: var(--success-light);
            color: var(--success-dark);
        }

        /* Chart Styles */
        .chart-container {
            background: white;
            border-radius: 0.75rem;
            padding: 1.25rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-light);
            height: 100%;
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem;
        }

        .chart-title {
            font-weight: 600;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.1rem;
        }

        .chart-period {
            font-size: 0.875rem;
            color: var(--text-secondary);
            background: var(--bg-light);
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
        }

        .chart-wrapper {
            height: 250px;
            position: relative;
        }

        /* Data Card Styles */
        .data-card {
            background: white;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-light);
            height: 100%;
        }

        .data-card-header {
            padding: 1rem 1.5rem;
            color: white;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 600;
        }

        .data-card-header i {
            font-size: 1.1rem;
        }

        .data-card-body {
            padding: 1rem 1.5rem;
        }

        .data-list-header {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 1rem;
            padding: 0.75rem 0;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--border-light);
        }

        .data-list-item {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-light);
            align-items: center;
        }

        .data-list-item:last-child {
            border-bottom: none;
        }

        .empty-state {
            text-align: center;
            padding: 2rem 1rem;
            color: var(--text-secondary);
        }

        .empty-state i {
            font-size: 2rem;
            margin-bottom: 0.75rem;
            opacity: 0.5;
        }

        .empty-state p {
            font-size: 0.9rem;
        }

        /* Star Rating */
        .star-rating {
            display: flex;
            align-items: center;
            gap: 0.15rem;
        }

        .star {
            color: #fbbf24;
            font-size: 0.9rem;
        }

        .empty-star {
            color: #e5e7eb;
            font-size: 0.9rem;
        }

        .rating-value {
            margin-left: 0.5rem;
            color: var(--text-secondary);
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
            opacity: 0;
        }

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        .delay-300 {
            animation-delay: 0.3s;
        }

        .delay-400 {
            animation-delay: 0.4s;
        }

        /* Responsive Grid System */
        .grid {
            display: grid;
            gap: 1.5rem;
        }

        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }

        @media (min-width: 640px) {
            .sm\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (min-width: 1024px) {
            .lg\:grid-cols-3 {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .lg\:grid-cols-4 {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }
        }

        /* Container and spacing */
        .container {
            width: 100%;
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        @media (min-width: 1024px) {
            .container {
                max-width: 1280px;
                margin-left: auto;
                margin-right: auto;
            }
        }

        .mb-6 {
            margin-bottom: 1.5rem;
        }

        /* Flexbox utilities */
        .flex {
            display: flex;
        }

        .flex-col {
            flex-direction: column;
        }

        .items-start {
            align-items: flex-start;
        }

        .items-center {
            align-items: center;
        }

        .justify-between {
            justify-content: space-between;
        }

        .gap-2 {
            gap: 0.5rem;
        }

        .gap-3 {
            gap: 0.75rem;
        }

        .gap-4 {
            gap: 1rem;
        }

        /* Text utilities */
        .text-sm {
            font-size: 0.875rem;
        }

        .text-lg {
            font-size: 1.125rem;
        }

        .text-right {
            text-align: right;
        }

        .text-white {
            color: white;
        }

        .font-medium {
            font-weight: 500;
        }

        .font-semibold {
            font-weight: 600;
        }

        .font-bold {
            font-weight: 700;
        }

        .opacity-90 {
            opacity: 0.9;
        }

        .truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Section styles */
        .section-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .section-title {
            font-size: 1.1rem;
            color: var(--text-secondary);
            margin-bottom: 2rem;
        }

        /* Miscellaneous */
        .mr-1 {
            margin-right: 0.25rem;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Admin Dashboard</h1>
            </div>

            <div class="section-body">
                <h2 class="section-title"> Cuisine Dashboard - Performance Overview</h2>

                <div class="container py-4">
                    <!-- Dashboard Header -->
                    <div class="dashboard-header animate-fade-in">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div>
                                <h1>Welcome back, Admin!</h1>
                                <p>Here's what's happening with your business today.</p>
                            </div>
                            <div class="date-display">
                                <div class="text-sm font-medium opacity-90">Waktu Indonesia Barat (WIB)</div>
                                <div class="time-display" id="indonesia-time"></div>
                                <div class="text-sm" id="indonesia-date"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics Section -->
                  <!-- Statistics Section - Ultra Compact Version -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
                        <!-- Users Card -->
                        <div class="bg-white rounded-lg shadow-xs p-3 hover:shadow-sm transition-shadow">
                            <div class="flex items-center gap-2">
                                <div class="bg-blue-50 p-2 rounded-full">
                                    <i class="fas fa-users text-blue-500 text-sm"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="font-semibold text-gray-800 text-md">{{ number_format($totalUsers) }}</div>
                                    <div class="text-gray-500 text-xs">Users</div>
                                    <div class="text-blue-500 text-2xs mt-0.5">+{{ $newUsersThisMonth }} month</div>
                                </div>
                            </div>
                        </div>

                        <!-- Revenue Card -->
                        <div class="bg-white rounded-lg shadow-xs p-3 hover:shadow-sm transition-shadow">
                            <div class="flex items-center gap-2">
                                <div class="bg-green-50 p-2 rounded-full">
                                    <i class="fas fa-coins text-green-500 text-sm"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="font-semibold text-gray-800 text-md">
                                        Rp{{ number_format($totalRevenue / 1000, 0) }}k</div>
                                    <div class="text-gray-500 text-xs">Revenue</div>
                                    <div class="text-green-500 text-2xs mt-0.5">
                                        Rp{{ number_format($revenueThisMonth / 1000, 0) }}k month</div>
                                </div>
                            </div>
                        </div>

                        <!-- Premium Recipes Card -->
                        <div class="bg-white rounded-lg shadow-xs p-3 hover:shadow-sm transition-shadow">
                            <div class="flex items-center gap-2">
                                <div class="bg-purple-50 p-2 rounded-full">
                                    <i class="fas fa-crown text-purple-500 text-sm"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="font-semibold text-gray-800 text-md">{{ number_format($totalPremiumSold) }}
                                    </div>
                                    <div class="text-gray-500 text-xs">Premium</div>
                                    <div class="text-purple-500 text-2xs mt-0.5">+{{ $newPremiumThisMonth }} sales</div>
                                </div>
                            </div>
                        </div>

                        <!-- Uploaded Recipes Card -->
                        <div class="bg-white rounded-lg shadow-xs p-3 hover:shadow-sm transition-shadow">
                            <div class="flex items-center gap-2">
                                <div class="bg-orange-50 p-2 rounded-full">
                                    <i class="fas fa-utensils text-orange-500 text-sm"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="font-semibold text-gray-800 text-md">{{ number_format($totalRecipes) }}
                                    </div>
                                    <div class="text-gray-500 text-xs">Recipes</div>
                                    <div class="text-orange-500 text-2xs mt-0.5">+{{ $newRecipesThisMonth }} new</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Section -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                        <!-- Revenue Chart -->
                        <div class="chart-container animate-fade-in delay-100">
                            <div class="chart-header">
                                <div class="chart-title">
                                    <i class="fas fa-chart-line"></i> Revenue Analysis
                                </div>
                                <div class="chart-period">
                                    <i class="far fa-calendar-alt mr-1"></i> Last 7 days
                                </div>
                            </div>
                            <div class="chart-wrapper">
                                <canvas id="revenueChart"></canvas>
                            </div>
                        </div>

                        <!-- Users Chart -->
                        <div class="chart-container animate-fade-in delay-200">
                            <div class="chart-header">
                                <div class="chart-title">
                                    <i class="fas fa-user-plus"></i> User Growth
                                </div>
                                <div class="chart-period">
                                    <i class="far fa-calendar-alt mr-1"></i> Last 30 days
                                </div>
                            </div>
                            <div class="chart-wrapper">
                                <canvas id="usersChart"></canvas>
                            </div>
                        </div>

                        <!-- Premium Sales Chart -->
                        <div class="chart-container animate-fade-in delay-300">
                            <div class="chart-header">
                                <div class="chart-title">
                                    <i class="fas fa-crown"></i> Premium Sales
                                </div>
                                <div class="chart-period">
                                    <i class="far fa-calendar-alt mr-1"></i> Last 7 days
                                </div>
                            </div>
                            <div class="chart-wrapper">
                                <canvas id="premiumSalesChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Data Cards Section -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Countries Card -->
                        <div class="data-card animate-fade-in delay-200">
                            <div class="data-card-header bg-gradient-to-r from-indigo-600 to-indigo-700">
                                <i class="fas fa-globe-americas"></i>
                                <h2>Top Countries</h2>
                            </div>
                            <div class="data-card-body">
                                <div class="data-list-header">
                                    <span>Country</span>
                                    <span>Users</span>
                                </div>

                                <div class="space-y-1">
                                    @if ($topCountries->isEmpty())
                                        <div class="empty-state">
                                            <i class="fas fa-globe"></i>
                                            <p>No country data available yet</p>
                                        </div>
                                    @else
                                        @foreach ($topCountries as $country)
                                            <div class="data-list-item">
                                                <span class="truncate font-medium">{{ $country['name'] }}</span>
                                                <span class="font-semibold">{{ number_format($country['count']) }}</span>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Ingredients Card -->
                        <div class="data-card animate-fade-in delay-300">
                            <div class="data-card-header bg-gradient-to-r from-green-600 to-green-700">
                                <i class="fas fa-carrot"></i>
                                <h2>Popular Ingredients</h2>
                            </div>
                            <div class="data-card-body">
                                <div class="data-list-header">
                                    <span>Ingredient</span>
                                    <span>Usage</span>
                                </div>

                                <div class="space-y-1">
                                    @if ($topIngredients->isEmpty())
                                        <div class="empty-state">
                                            <i class="fas fa-carrot"></i>
                                            <p>No ingredient data available yet</p>
                                        </div>
                                    @else
                                        @foreach ($topIngredients as $ingredient)
                                            <div class="data-list-item">
                                                <span class="truncate font-medium">{{ $ingredient['name'] }}</span>
                                                <span
                                                    class="font-semibold">{{ number_format($ingredient['count']) }}</span>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Recipes Card -->
                        <div class="data-card animate-fade-in delay-400">
                            <div class="data-card-header bg-gradient-to-r from-blue-600 to-blue-700">
                                <i class="fas fa-utensils"></i>
                                <h2>Top Rated Recipes</h2>
                            </div>
                            <div class="data-card-body">
                                <div class="data-list-header">
                                    <span>Recipe</span>
                                    <span>Rating</span>
                                </div>

                                <div class="space-y-1">
                                    @if ($topRecipes->isEmpty())
                                        <div class="empty-state">
                                            <i class="fas fa-utensils"></i>
                                            <p>No recipe data available yet</p>
                                        </div>
                                    @else
                                        @foreach ($topRecipes as $recipe)
                                            <div class="data-list-item">
                                                <span class="truncate font-medium">{{ $recipe['display_name'] }}</span>
                                                <div class="star-rating">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $recipe['rating'])
                                                            <span class="star">★</span>
                                                        @else
                                                            <span class="empty-star">★</span>
                                                        @endif
                                                    @endfor
                                                    <span
                                                        class="rating-value">{{ number_format($recipe['rating'], 1) }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection


@push('scripts')
    <script>
        // Formatting helpers
        const monthNames = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];

        const dayNames = [
            "Minggu", "Senin", "Selasa", "Rabu",
            "Kamis", "Jumat", "Sabtu"
        ];

        // Function to format date to Indonesian format
        function formatIndonesianDate(dateString) {
            const date = new Date(dateString);
            const day = dayNames[date.getDay()];
            const dateNum = date.getDate();
            const month = monthNames[date.getMonth()];
            const year = date.getFullYear();
            return `${day}, ${dateNum} ${month} ${year}`;
        }

        // Function to update Indonesia time and date
        function updateIndonesiaDateTime() {
            const now = new Date();

            // Format time
            const timeOptions = {
                timeZone: 'Asia/Jakarta',
                hour12: false,
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            const timeString = new Intl.DateTimeFormat('id-ID', timeOptions).format(now);
            document.getElementById('indonesia-time').textContent = timeString;

            // Format date in Indonesian
            const dateString = formatIndonesianDate(now);
            document.getElementById('indonesia-date').textContent = dateString;
        }

        // Update time immediately and then every second
        updateIndonesiaDateTime();
        setInterval(updateIndonesiaDateTime, 1000);

        function formatCurrency(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(amount);
        }

        // Common chart configuration
        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#1f2937',
                    titleFont: {
                        size: 12,
                        weight: '600'
                    },
                    bodyFont: {
                        size: 11
                    },
                    padding: 10,
                    cornerRadius: 6,
                    displayColors: false
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45,
                        padding: 6,
                        font: {
                            size: 10
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f3f4f6'
                    },
                    ticks: {
                        padding: 8,
                        font: {
                            size: 10
                        }
                    }
                }
            }
        };

        // Initialize charts when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Revenue Chart
            if (document.getElementById('revenueChart')) {
                new Chart(document.getElementById('revenueChart'), {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($revenueData->pluck('date')) !!}.map(date => formatIndonesianDate(date)),
                        datasets: [{
                            data: {!! json_encode($revenueData->pluck('amount')) !!},
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            borderWidth: 2,
                            tension: 0.3,
                            pointRadius: 3,
                            pointHoverRadius: 5
                        }]
                    },
                    options: {
                        ...chartOptions,
                        plugins: {
                            ...chartOptions.plugins,
                            tooltip: {
                                ...chartOptions.plugins.tooltip,
                                callbacks: {
                                    label: (ctx) => formatCurrency(ctx.raw)
                                }
                            }
                        },
                        scales: {
                            ...chartOptions.scales,
                            y: {
                                ...chartOptions.scales.y,
                                ticks: {
                                    ...chartOptions.scales.y.ticks,
                                    callback: (value) => formatCurrency(value)
                                }
                            }
                        }
                    }
                });
            }

            // Users Chart
            if (document.getElementById('usersChart')) {
                new Chart(document.getElementById('usersChart'), {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($userData->pluck('date')) !!}.map(date => formatIndonesianDate(date)),
                        datasets: [{
                            data: {!! json_encode($userData->pluck('count')) !!},
                            backgroundColor: '#3b82f6',
                            borderRadius: 6,
                            maxBarThickness: 30
                        }]
                    },
                    options: chartOptions
                });
            }

            // Premium Sales Chart
            if (document.getElementById('premiumSalesChart')) {
                new Chart(document.getElementById('premiumSalesChart'), {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($premiumSalesData->pluck('date')) !!}.map(date => formatIndonesianDate(date)),
                        datasets: [{
                            data: {!! json_encode($premiumSalesData->pluck('count')) !!},
                            backgroundColor: '#f59e0b',
                            borderRadius: 6,
                            maxBarThickness: 30
                        }]
                    },
                    options: chartOptions
                });
            }

            // Handle window resize
            let resizeTimer;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => {
                    window.dispatchEvent(new Event('resize'));
                }, 200);
            });
        });
    </script>
@endpush
