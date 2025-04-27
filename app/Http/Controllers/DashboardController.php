<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PaymentItem;
use App\Models\Recipe;
use App\Models\Review;
use App\Models\User;
use App\Models\UserPreference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $type_menu = 'dashboard';

        // Main statistics
        $totalUsers = User::count();
        $totalRevenue = Payment::where('status', 'approved')->sum('total_amount');
        $totalPremiumSold = Payment::where('status', 'approved')->distinct()->count();
        $totalRecipes = Recipe::count();

        // Monthly changes for dashboard cards
        $newUsersThisMonth = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $revenueThisMonth = Payment::where('status', 'approved')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');

        $newPremiumThisMonth = Payment::where('status', 'approved')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->distinct()
            ->count();

        $newRecipesThisMonth = Recipe::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Get top 5 countries, ingredients, recipes
        $topCountries = $this->getTopCountries();
        $topIngredients = $this->getTopIngredients();
        $topRecipes = $this->getTopRecipes();

        // Revenue data for last 7 days
        $revenueData = Payment::selectRaw('DATE(created_at) as date, SUM(total_amount) as amount')
            ->whereDate('created_at', '>=', now()->subDays(7))
            ->where('status', 'approved')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // User data for last 7 days
        $userData = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereDate('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Premium sales data for last 7 days
        $premiumSalesData = PaymentItem::selectRaw('DATE(payments.created_at) as date, COUNT(*) as count')
            ->join('payments', 'payment_items.payment_id', '=', 'payments.id')
            ->where('payments.status', 'approved')
            ->whereDate('payments.created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Format labels for charts
        foreach ($revenueData as $data) {
            $data->label = Carbon::parse($data->date)->format('M d');
        }

        foreach ($userData as $data) {
            $data->label = Carbon::parse($data->date)->format('M d');
        }

        foreach ($premiumSalesData as $data) {
            $data->label = Carbon::parse($data->date)->format('M d');
        }

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalRevenue',
            'totalPremiumSold',
            'totalRecipes',
            'newUsersThisMonth',
            'revenueThisMonth',
            'newPremiumThisMonth',
            'newRecipesThisMonth',
            'revenueData',
            'topCountries',
            'topIngredients',
            'topRecipes',
            'userData',
            'premiumSalesData',
            'type_menu'
        ));
    }

    /**
     * Get top 5 countries based on user preferences and reviews.
     */
    private function getTopCountries()
    {
        // First method: from user_preferences table
        $countriesFromPreferences = UserPreference::select('country')
            ->whereNotNull('country')
            ->get()
            ->flatMap(function ($preference) {
                // Parse the JSON field
                $countries = json_decode($preference->country, true);
                return is_array($countries) ? $countries : [$countries];
            })
            ->countBy() // Count occurrences of each country
            ->sortDesc() // Sort by count in descending order
            ->take(5); // Take top 5 countries

        // Transform the result into the desired format
        $topCountries = $countriesFromPreferences->map(function ($count, $country) {
            return [
                'name' => $country,
                'count' => $count, // Use the count of users as the value
            ];
        })->values(); // Ensure the result is a plain array

        return $topCountries;
    }

    /**
     * Get top 5 ingredients based on user preferences.
     */
    private function getTopIngredients()
    {
        // Combine primary and secondary ingredients from user preferences
        $allIngredients = collect();

        // Get primary ingredients
        $primaryIngredients = UserPreference::select('primary_ingredient')
            ->whereNotNull('primary_ingredient')
            ->get()
            ->flatMap(function ($preference) {
                $ingredients = json_decode($preference->primary_ingredient, true);
                return is_array($ingredients) ? $ingredients : [$ingredients];
            })
            ->countBy();

        // Get secondary ingredients
        $secondaryIngredients = UserPreference::select('secondary_ingredient')
            ->whereNotNull('secondary_ingredient')
            ->get()
            ->flatMap(function ($preference) {
                $ingredients = json_decode($preference->secondary_ingredient, true);
                return is_array($ingredients) ? $ingredients : [$ingredients];
            })
            ->countBy();

        // Combine and prioritize primary ingredients
        foreach ($primaryIngredients as $ingredient => $count) {
            $allIngredients->put($ingredient, [
                'name' => $ingredient,
                'count' => $count * 2, // Give more weight to primary ingredients
            ]);
        }

        foreach ($secondaryIngredients as $ingredient => $count) {
            if ($allIngredients->has($ingredient)) {
                $allIngredients[$ingredient]['count'] += $count;
            } else {
                $allIngredients->put($ingredient, [
                    'name' => $ingredient,
                    'count' => $count,
                ]);
            }
        }

        // Return top 5 ingredients sorted by count
        return $allIngredients->sortByDesc('count')->take(5)->values();
    }

    /**
     * Get top 5 recipes based on reviews.
     */
    private function getTopRecipes()
    {
        return Recipe::select('recipes.id', 'recipes.name', DB::raw('AVG(reviews.rating) as average_rating'))
            ->join('reviews', 'recipes.id', '=', 'reviews.recipe_id')
            ->groupBy('recipes.id', 'recipes.name')
            ->orderBy('average_rating', 'desc')
            ->take(5)
            ->get()
            ->map(function ($recipe) {
                // Truncate long recipe names for display
                if (strlen($recipe->name) > 15) {
                    $recipe->display_name = substr($recipe->name, 0, 12) . '...';
                } else {
                    $recipe->display_name = $recipe->name;
                }

                return [
                    'id' => $recipe->id,
                    'name' => $recipe->name,
                    'display_name' => $recipe->display_name,
                    'rating' => $recipe->average_rating
                ];
            });
    }
}
