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
     * Only shows recipes that match ALL user preference criteria.
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

        // Combine primary and secondary ingredients for ingredient matching
        $allUserIngredients = array_merge($primaryIngredients, $secondaryIngredients);

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

        // Function to normalize ingredient names for comparison (handle underscores and case)
        $normalizeIngredient = function($ingredient) {
            // Replace underscores with spaces
            $normalized = str_replace('_', ' ', $ingredient);
            // Convert to lowercase for case-insensitive comparison
            return strtolower(trim($normalized));
        };

        // Get all recipes
        $allRecipes = Recipe::all();
        $matchingRecipes = collect();

        foreach ($allRecipes as $recipe) {
            // Check country match
            $recipeCountry = $recipe->country;
            if (is_string($recipeCountry) && (substr($recipeCountry, 0, 1) === '[')) {
                $recipeCountry = json_decode($recipeCountry, true);
                if (is_array($recipeCountry) && count($recipeCountry) > 0) {
                    $recipeCountry = $recipeCountry[0];
                }
            }
            $recipeCountry = is_string($recipeCountry) ? strtolower($recipeCountry) : '';

            // If countries preference is empty, consider it a match by default
            // Otherwise, check if the recipe country is in user's preferred countries
            $countryMatches = empty($countries) || in_array($recipeCountry, $countries);

            if (!$countryMatches) {
                continue; // Skip this recipe if country doesn't match
            }

            // Check spiciness match
            $recipeSpiciness = $recipe->spiciness;
            if (is_string($recipeSpiciness) && (substr($recipeSpiciness, 0, 1) === '[')) {
                $recipeSpiciness = json_decode($recipeSpiciness, true);
                if (is_array($recipeSpiciness) && count($recipeSpiciness) > 0) {
                    $recipeSpiciness = $recipeSpiciness[0];
                }
            }
            $recipeSpiciness = is_string($recipeSpiciness) ? strtolower($recipeSpiciness) : '';

            // Map recipe spiciness from Indonesian to English if needed
            if (array_key_exists($recipeSpiciness, $spicinessMap)) {
                $recipeSpiciness = $spicinessMap[$recipeSpiciness];
            }

            // If spiciness preference exists, it must match
            $spicinessMatches = empty($spicinessInEnglish) || $recipeSpiciness === $spicinessInEnglish;

            if (!$spicinessMatches) {
                continue; // Skip this recipe if spiciness doesn't match
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

            // Normalize recipe ingredients for better matching
            $normalizedRecipeIngredients = [];
            foreach ($recipeIngredients as $ingredient) {
                $normalizedRecipeIngredients[] = $normalizeIngredient($ingredient);
            }

            // Check if at least one user ingredient is present in the recipe
            $ingredientMatches = false;

            // If no ingredients are specified, consider it a match by default
            if (empty($allUserIngredients)) {
                $ingredientMatches = true;
            } else {
                foreach ($allUserIngredients as $ingredient) {
                    $normalizedIngredient = $normalizeIngredient($ingredient);

                    // Check in normalized ingredient array
                    if (in_array($normalizedIngredient, $normalizedRecipeIngredients)) {
                        $ingredientMatches = true;
                        break;
                    }
                    // Check in raw string if it's a string
                    elseif (is_string($recipe->ingredients)) {
                        $lowerRecipeIngredients = strtolower($recipe->ingredients);

                        if (
                            stripos($lowerRecipeIngredients, $ingredient) !== false ||
                            stripos($lowerRecipeIngredients, $normalizedIngredient) !== false ||
                            stripos($lowerRecipeIngredients, str_replace(' ', '_', $ingredient)) !== false
                        ) {
                            $ingredientMatches = true;
                            break;
                        }
                    }
                }
            }

            if (!$ingredientMatches) {
                continue; // Skip this recipe if no ingredients match
            }

            // If we got here, this recipe matches all criteria
            // Calculate relevance score for sorting
            $score = 0;

            // Country match
            if (in_array($recipeCountry, $countries)) {
                $score += 2;
            }

            // Spiciness match
            if ($recipeSpiciness === $spicinessInEnglish) {
                $score += 2;
            }

            // Primary ingredients matches (higher score)
            foreach ($primaryIngredients as $ingredient) {
                $normalizedIngredient = $normalizeIngredient($ingredient);

                if (in_array($normalizedIngredient, $normalizedRecipeIngredients) ||
                    (is_string($recipe->ingredients) &&
                     (stripos(strtolower($recipe->ingredients), $ingredient) !== false ||
                      stripos(strtolower($recipe->ingredients), $normalizedIngredient) !== false ||
                      stripos(strtolower($recipe->ingredients), str_replace(' ', '_', $ingredient)) !== false))) {
                    $score += 3;
                }
            }

            // Secondary ingredients matches (lower score)
            foreach ($secondaryIngredients as $ingredient) {
                $normalizedIngredient = $normalizeIngredient($ingredient);

                if (in_array($normalizedIngredient, $normalizedRecipeIngredients) ||
                    (is_string($recipe->ingredients) &&
                     (stripos(strtolower($recipe->ingredients), $ingredient) !== false ||
                      stripos(strtolower($recipe->ingredients), $normalizedIngredient) !== false ||
                      stripos(strtolower($recipe->ingredients), str_replace(' ', '_', $ingredient)) !== false))) {
                    $score += 1;
                }
            }

            $recipe->relevance_score = $score;
            $matchingRecipes->push($recipe);
        }

        // Calculate max possible score for percentage calculation in the view
        $maxPossibleScore = 2 + // Country match
                           (count($primaryIngredients) * 3) + // Primary ingredients (3 points each)
                           (count($secondaryIngredients) * 1) + // Secondary ingredients (1 point each)
                           2; // Spiciness match

        // Sort recipes by relevance score (highest first) and take top 10
        $recommendedRecipes = $matchingRecipes->sortByDesc('relevance_score')->take(10);

        return view('main.recommendations.index', [
            'recommendations' => $recommendedRecipes,
            'userPreference' => $userPreference,
            'maxPossibleScore' => $maxPossibleScore
        ]);
    }
}
