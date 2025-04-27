<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\UserPreference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecommendationController extends Controller
{
    /**
     * Display a listing of recommended recipes based on user preferences.
     */
    public function index() {
        
        if (!Auth::check()) {
            return redirect()->route('user.login.form')
                ->with('error', 'You must be logged in to view recommendations.');
        }
        // Get user preferences
        $userPreference = UserPreference::where('users', Auth::id())->first();

        if (!$userPreference) {
            return redirect()->route('user.recommendation.index')
                ->with('info', 'Harap atur preferensi makanan Anda terlebih dahulu untuk mendapatkan rekomendasi.');
        }

        // Ensure preference fields are properly decoded into arrays
        $countries = is_string($userPreference->country) ? json_decode($userPreference->country, true) : $userPreference->country;
        $primaryIngredients = is_string($userPreference->primary_ingredient) ? json_decode($userPreference->primary_ingredient, true) : $userPreference->primary_ingredient;
        $secondaryIngredients = is_string($userPreference->secondary_ingredient) ? json_decode($userPreference->secondary_ingredient, true) : $userPreference->secondary_ingredient;

        // Make sure we have arrays (not null)
        $countries = is_array($countries) ? $countries : [];
        $primaryIngredients = is_array($primaryIngredients) ? $primaryIngredients : [];
        $secondaryIngredients = is_array($secondaryIngredients) ? $secondaryIngredients : [];

        // Convert all preference values to lowercase for case-insensitive comparison
        $countries = array_map('strtolower', $countries);
        $primaryIngredients = array_map('strtolower', $primaryIngredients);
        $secondaryIngredients = array_map('strtolower', $secondaryIngredients);

        // Spiciness is stored as ["sedang"], need to get the first element
        $spicinessValue = is_string($userPreference->spiciness) ? json_decode($userPreference->spiciness, true) : $userPreference->spiciness;
        if (is_array($spicinessValue) && count($spicinessValue) > 0) {
            $spiciness = strtolower($spicinessValue[0]); // Convert to lowercase
        } else {
            $spiciness = 'sedang'; // Default value
        }

        // Map spiciness from Indonesian to English
        $spicinessMap = [
            'ringan' => 'low',
            'sedang' => 'medium',
            'pedas' => 'high'
        ];

        $spicinessInEnglish = $spicinessMap[$spiciness] ?? 'medium';

        // Query recipes and calculate relevance scores
        $recipes = Recipe::all()->map(function($recipe) use ($countries, $primaryIngredients, $secondaryIngredients, $spicinessInEnglish, $spicinessMap) {
            $score = 0;

            // Country matching - ensure we're comparing safely
            $recipeCountry = $recipe->country;
            if (is_string($recipeCountry) && (substr($recipeCountry, 0, 1) === '[')) {
                $recipeCountry = json_decode($recipeCountry, true);
                if (is_array($recipeCountry) && count($recipeCountry) > 0) {
                    $recipeCountry = $recipeCountry[0];
                }
            }

            // Convert recipe country to lowercase for case-insensitive comparison
            $recipeCountry = is_string($recipeCountry) ? strtolower($recipeCountry) : '';

            if (!empty($recipeCountry) && in_array($recipeCountry, $countries)) {
                $score += 2;
            }

            // Parse recipe ingredients - ensure we have an array to work with
            $recipeIngredients = [];

            // Handle different formats of ingredients storage
            if (!empty($recipe->ingredients)) {
                if (is_string($recipe->ingredients)) {
                    // Try to decode JSON string
                    $decoded = json_decode($recipe->ingredients, true);
                    if (is_array($decoded)) {
                        $recipeIngredients = $decoded;
                    } else {
                        // If not JSON, split by commas or other delimiters
                        $recipeIngredients = array_map('trim', explode(',', $recipe->ingredients));
                    }
                } elseif (is_array($recipe->ingredients)) {
                    $recipeIngredients = $recipe->ingredients;
                }
            }

            // Function to normalize ingredient names for comparison (handle underscores and case)
            $normalizeIngredient = function($ingredient) {
                // Replace underscores with spaces
                $normalized = str_replace('_', ' ', $ingredient);
                // Convert to lowercase for case-insensitive comparison
                return strtolower(trim($normalized));
            };

            // Normalize recipe ingredients for better matching
            $normalizedRecipeIngredients = [];
            foreach ($recipeIngredients as $ingredient) {
                $normalizedRecipeIngredients[] = $normalizeIngredient($ingredient);
            }

            // Check primary ingredients (higher score impact)
            foreach ($primaryIngredients as $ingredient) {
                $found = false;
                $normalizedIngredient = $normalizeIngredient($ingredient);

                // Check if normalized ingredient exists in normalized recipe ingredients array
                if (in_array($normalizedIngredient, $normalizedRecipeIngredients)) {
                    $found = true;
                }
                // Also check in the raw string if it's a string (both with and without underscores)
                elseif (is_string($recipe->ingredients)) {
                    // Convert recipe ingredients to lowercase for case-insensitive comparison
                    $lowerRecipeIngredients = strtolower($recipe->ingredients);
                    
                    // Check with original format
                    if (stripos($lowerRecipeIngredients, $ingredient) !== false) {
                        $found = true;
                    }
                    // Check with underscores replaced with spaces
                    elseif (stripos($lowerRecipeIngredients, $normalizedIngredient) !== false) {
                        $found = true;
                    }
                    // Check with spaces replaced with underscores
                    elseif (stripos($lowerRecipeIngredients, str_replace(' ', '_', $ingredient)) !== false) {
                        $found = true;
                    }
                }

                if ($found) {
                    $score += 3;
                }
            }

            // Check secondary ingredients (lower score impact)
            foreach ($secondaryIngredients as $ingredient) {
                $found = false;
                $normalizedIngredient = $normalizeIngredient($ingredient);

                // Check if normalized ingredient exists in normalized recipe ingredients array
                if (in_array($normalizedIngredient, $normalizedRecipeIngredients)) {
                    $found = true;
                }
                // Also check in the raw string if it's a string (both with and without underscores)
                elseif (is_string($recipe->ingredients)) {
                    // Convert recipe ingredients to lowercase for case-insensitive comparison
                    $lowerRecipeIngredients = strtolower($recipe->ingredients);
                    
                    // Check with original format
                    if (stripos($lowerRecipeIngredients, $ingredient) !== false) {
                        $found = true;
                    }
                    // Check with underscores replaced with spaces
                    elseif (stripos($lowerRecipeIngredients, $normalizedIngredient) !== false) {
                        $found = true;
                    }
                    // Check with spaces replaced with underscores
                    elseif (stripos($lowerRecipeIngredients, str_replace(' ', '_', $ingredient)) !== false) {
                        $found = true;
                    }
                }

                if ($found) {
                    $score += 1;
                }
            }

            // Match spiciness level - ensure we're comparing safely
            $recipeSpiciness = $recipe->spiciness;

            // Handle JSON string format if needed
            if (is_string($recipeSpiciness) && (substr($recipeSpiciness, 0, 1) === '[')) {
                $recipeSpiciness = json_decode($recipeSpiciness, true);
                if (is_array($recipeSpiciness) && count($recipeSpiciness) > 0) {
                    $recipeSpiciness = $recipeSpiciness[0];
                }
            }

            // Convert recipe spiciness to lowercase for case-insensitive comparison
            $recipeSpiciness = is_string($recipeSpiciness) ? strtolower($recipeSpiciness) : '';

            // Map recipe spiciness from Indonesian to English if needed
            if (array_key_exists($recipeSpiciness, $spicinessMap)) {
                $recipeSpiciness = $spicinessMap[$recipeSpiciness];
            }

            if ($recipeSpiciness === $spicinessInEnglish) {
                $score += 2;
            }

            $recipe->relevance_score = $score;
            return $recipe;
        });

        // Calculate max possible score for percentage calculation in the view
        $maxPossibleScore = 2 + // Country match
                           (count($primaryIngredients) * 3) + // Primary ingredients (3 points each)
                           (count($secondaryIngredients) * 1) + // Secondary ingredients (1 point each)
                           2; // Spiciness match

        // Sort recipes by relevance score (highest first) and take top 10
        $recommendedRecipes = $recipes->sortByDesc('relevance_score')->take(10);

        return view('main.recommendations.index', [
            'recommendations' => $recommendedRecipes,
            'userPreference' => $userPreference,
            'maxPossibleScore' => $maxPossibleScore
        ]);
    }
}