<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Article;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // Get sort parameter (default to 'latest')
        $sort = $request->query('sort', 'latest');

        // Base query
        $query = Recipe::query();

        // Apply sorting
        switch ($sort) {
            case 'top-rated':
                $query->leftJoin('reviews', 'recipes.id', '=', 'reviews.recipe_id')
                    ->select('recipes.*', DB::raw('COALESCE(AVG(reviews.rating), 0) as avg_rating'))
                    ->groupBy(
                        'recipes.id',
                        'recipes.category_id',
                        'recipes.user_preference_id',
                        'recipes.name',
                        'recipes.price',
                        'recipes.instructions',
                        'recipes.image',
                        'recipes.country',
                        'recipes.detail',
                        'recipes.ingredients',
                        'recipes.spiciness',
                        'recipes.premium',
                        'recipes.created_at',
                        'recipes.updated_at'
                    )
                    ->orderByDesc('avg_rating');
                break;
            case 'trending':
                $query->withCount(['reviews' => function ($query) {
                    $query->where('created_at', '>=', now()->subDays(30));
                }])
                    ->orderByDesc('reviews_count');
                break;
            case 'latest':
            default:
                $query->latest('created_at');
                break;
        }

        // Get paginated recipes
        $recipes = $query->paginate(9);

        // Eager load reviews for displaying ratings
        $recipes = $query->with('reviews')->paginate(9);
        // Get articles for the article section
        $articles = Article::latest('news_date')->paginate(5);

        return view('main.index', compact('recipes', 'articles'));
    }

    /**
     * Search for recipes.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function search(Request $request)
    {
        $searchQuery = $request->input('query', ''); // Default empty string jika null

        // Query Recipes
        $recipesQuery = Recipe::query();

        if ($searchQuery) {
            $recipesQuery->where('name', 'like', '%' . $searchQuery . '%')
                ->orWhereHas('category', function ($q) use ($searchQuery) {
                    $q->where('name', 'like', '%' . $searchQuery . '%');
                });
        }

        $recipes = $recipesQuery->with(['category', 'reviews'])
            ->simplePaginate(9)
            ->appends($request->query()); // Alternatif withQueryString()

        // Query Articles
        $articlesQuery = Article::query();

        if ($searchQuery) {
            $articlesQuery->where(function ($q) use ($searchQuery) {
                $q->where('title', 'like', '%' . $searchQuery . '%')
                    ->orWhere('detail', 'like', '%' . $searchQuery . '%');
            });
        }

        $articles = $articlesQuery->latest('created_at') // Ganti dengan kolom yang ada
            ->paginate(5)
            ->appends($request->query());

        return view('main.index', compact('recipes', 'articles', 'searchQuery'));
    }

    public function searchRecommendation(Request $request)
    {
        $searchQuery = $request->input('query');

        $recipes = Recipe::where('name', 'LIKE', "%{$searchQuery}%")
            // ->orWhere('country', 'LIKE', "%{$searchQuery}%")
            // ->orWhere('detail', 'LIKE', "%{$searchQuery}%")
            ->paginate(9);

        $recipes->load('reviews');

        // Get articles for the article section (needed for your current view)
        $articles = Article::where('title', 'LIKE', "%{$searchQuery}%")
            // ->orWhere('detail', 'LIKE', "%{$searchQuery}%")
            ->latest('news_date')
            ->paginate(5);



        return view('main.recommendations.index', compact('recipes', 'articles', 'searchQuery'));
    }

    /**
     * Display recipes by cuisine type (free only).
     *
     * @param  string  $cuisine
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function cuisine($cuisine)
    {
        $recipes = Recipe::where('country', $cuisine)
            ->where('price', 0)  // Assuming free recipes have price of 0
            ->paginate(9);

        $recipes->load('reviews');

        // Get articles for the article section
        $articles = Article::latest('news_date')->paginate(5);

        return view('main.index', compact('recipes', 'articles'));
    }

    /**
     * Display premium recipes by cuisine type.
     *
     * @param  string  $cuisine
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function premium($cuisine)
    {
        $recipes = Recipe::where('country', $cuisine)
            ->where('price', '>', 0)  // Premium recipes have price > 0
            ->paginate(9);

        $recipes->load('reviews');

        // Get articles for the article section
        $articles = Article::latest('news_date')->paginate(5);

        return view('main.index', compact('recipes', 'articles'));
    }
}
