<?php

namespace App\Services;

use App\Models\Recipe;
use App\Models\UserPreference;
use Illuminate\Pagination\LengthAwarePaginator;

class RecommendationService
{
    /**
     * Get recommended recipes for a user
     *
     * @param int $userId
     * @param int $limit Number of recommendations to return
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getRecommendationsForUser(int $userId, int $limit = 10)
    {
        // Get user preferences
        $userPreference = UserPreference::where('users', $userId)->first();

        if (!$userPreference) {
            // If no preferences, return popular recipes
            return $this->getPopularRecipes($limit);
        }

        // Decode JSON preferences
        $preferredCountries = json_decode($userPreference->country, true);
        $primaryIngredients = json_decode($userPreference->primary_ingredient, true);
        $secondaryIngredients = json_decode($userPreference->secondary_ingredient, true);
        $spiciness = json_decode($userPreference->spiciness, true);

        // Build query with preferences
        $query = Recipe::query();

        // Match country preferences
        if (!empty($preferredCountries)) {
            $query->whereIn('country', $preferredCountries);
        }

        // Match spiciness level
        if (!empty($spiciness)) {
            $query->whereIn('spiciness', $spiciness);
        }

        // For ingredient matching, we need to query the JSON field
        // This creates a more complex query with a relevance score
        $recipes = $query->get();

        // Process recipes to score them based on ingredients
        $scoredRecipes = $recipes->map(function ($recipe) use ($primaryIngredients, $secondaryIngredients) {
            $recipeIngredients = json_decode($recipe->ingredients, true);
            $score = 0;

            // Score primary ingredients (higher weight)
            foreach ($primaryIngredients as $ingredient) {
                if ($this->hasIngredient($recipeIngredients, $ingredient)) {
                    $score += 5;
                }
            }

            // Score secondary ingredients (lower weight)
            foreach ($secondaryIngredients as $ingredient) {
                if ($this->hasIngredient($recipeIngredients, $ingredient)) {
                    $score += 2;
                }
            }

            $recipe->relevance_score = $score;
            return $recipe;
        });

        // Sort by relevance score and limit results
        $sortedRecipes = $scoredRecipes->sortByDesc('relevance_score')->take($limit);

        // Convert to pagination for consistency with the rest of the application
        $currentPage = request()->get('page', 1);
        $perPage = 9; // Match your existing pagination

        $items = $sortedRecipes->forPage($currentPage, $perPage);

        return new LengthAwarePaginator(
            $items,
            count($sortedRecipes),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }

    /**
     * Check if a recipe has a specific ingredient
     *
     * @param array $ingredients Recipe ingredients
     * @param string $searchIngredient Ingredient to search for
     * @return bool
     */
    private function hasIngredient(array $ingredients, string $searchIngredient): bool
    {
        foreach ($ingredients as $ingredient) {
            if (isset($ingredient['name']) &&
                stripos($ingredient['name'], $searchIngredient) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get popular recipes as fallback
     *
     * @param int $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    private function getPopularRecipes(int $limit): \Illuminate\Pagination\LengthAwarePaginator
    {
        // This is a placeholder - implement based on your metrics for popularity
        // Could be based on views, ratings, etc.
        return Recipe::orderBy('created_at', 'desc')->paginate($limit);
    }

    /**
     * Get recommendations filtered by category
     *
     * @param int $userId
     * @param string $category
     * @param int $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getRecommendationsByCategory(int $userId, string $category, int $limit = 10)
    {
        // Get basic recommendations
        $recommendations = $this->getRecommendationsForUser($userId, 50); // Get more to filter from

        // Convert to collection
        $collection = collect($recommendations->items());

        // Filter by category
        switch ($category) {
            case 'diabetic':
                $filtered = $collection->filter(function($recipe) {
                    return $recipe->is_diabetic_friendly == 1;
                });
                break;
            case 'gluten-free':
                $filtered = $collection->filter(function($recipe) {
                    return $recipe->is_gluten_free == 1;
                });
                break;
            case 'high-fiber':
                $filtered = $collection->filter(function($recipe) {
                    return $recipe->is_high_fiber == 1;
                });
                break;
            case 'low-calorie':
                $filtered = $collection->filter(function($recipe) {
                    return $recipe->calories < 300; // Assuming low calorie threshold
                });
                break;
            default:
                $filtered = $collection;
        }

        // Convert back to pagination
        $currentPage = request()->get('page', 1);
        $perPage = 9; // Match your existing pagination

        $items = $filtered->take($limit)->forPage($currentPage, $perPage);

        return new LengthAwarePaginator(
            $items,
            count($filtered),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }

    /**
     * Get recommendations filtered by cuisine
     *
     * @param int $userId
     * @param string $cuisine
     * @param int $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getRecommendationsByCuisine(int $userId, string $cuisine, int $limit = 10)
    {
        // Map cuisine parameter to actual country values in database
        $cuisineMap = [
            'korean' => 'Korean',
            'indonesian' => 'Indonesian',
            'japanese' => 'Japanese',
            'indian' => 'Indian',
            'western' => 'Western',
            'italian' => 'Italian'
        ];

        // Get the actual cuisine name from the map
        $cuisineName = $cuisineMap[$cuisine] ?? $cuisine;

        // Create a query
        $query = Recipe::where('country', $cuisineName);

        // Add user preference scores if available
        $userPreference = UserPreference::where('users', $userId)->first();

        if ($userPreference) {
            $primaryIngredients = json_decode($userPreference->primary_ingredient, true);
            $secondaryIngredients = json_decode($userPreference->secondary_ingredient, true);

            $recipes = $query->get();

            // Calculate relevance scores
            $scoredRecipes = $recipes->map(function ($recipe) use ($primaryIngredients, $secondaryIngredients) {
                $recipeIngredients = json_decode($recipe->ingredients, true);
                $score = 0;

                // Score ingredients
                foreach ($primaryIngredients as $ingredient) {
                    if ($this->hasIngredient($recipeIngredients, $ingredient)) {
                        $score += 5;
                    }
                }

                foreach ($secondaryIngredients as $ingredient) {
                    if ($this->hasIngredient($recipeIngredients, $ingredient)) {
                        $score += 2;
                    }
                }

                $recipe->relevance_score = $score;
                return $recipe;
            });

            // Sort and paginate
            $sortedRecipes = $scoredRecipes->sortByDesc('relevance_score');

            $currentPage = request()->get('page', 1);
            $perPage = 9;

            $items = $sortedRecipes->forPage($currentPage, $perPage);

            return new LengthAwarePaginator(
                $items,
                count($sortedRecipes),
                $perPage,
                $currentPage,
                ['path' => request()->url(), 'query' => request()->query()]
            );
        } else {
            // Just return the cuisine recipes without scoring
            return $query->paginate($limit);
        }
    }
}
