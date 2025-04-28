<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Recipe;
use App\Models\Review;
use App\Models\User;
use App\Models\Payment;
use App\Models\PaymentItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CatalogController extends Controller
{
    /**
     * Menampilkan daftar resep
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
                          'recipes.id', 'recipes.category_id', 'recipes.user_preference_id',
                          'recipes.name', 'recipes.price', 'recipes.instructions',
                          'recipes.image', 'recipes.country', 'recipes.detail',
                          'recipes.ingredients', 'recipes.spiciness', 'recipes.premium',
                          'recipes.created_at', 'recipes.updated_at'
                      )
                      ->orderByDesc('avg_rating');
                break;
            case 'trending':
                $query->withCount(['reviews' => function($query) {
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
        $recipes = $query->paginate(6);

        // Eager load reviews for displaying ratings
        $recipes = $query->with('reviews')->paginate(9);
        // Get articles for the article section
        $articles = Article::latest('news_date')->paginate(5);

        // $articles = Article::latest()->take(5)->paginate(5);
        // $recipes = Recipe::all();



        // $recipes = Recipe::with('category')->latest()->paginate(9);
        $categories = Category::all();

        return view('main.index', [
            'articles' => $articles,
            'recipes' => $recipes,
            'categories' => $categories
        ]);
    }

    public function article()
    {
        $articles = Article::orderBy('news_date', 'desc')->paginate(6);
        return view('main.article.article', compact('articles'));
    }


    public function articleshow($id)
    {
        $article = Article::findOrFail($id);

        // Format the article content into paragraphs
        $formattedContent = $this->formatArticleContent($article->detail);
        $article->formatted_detail = $formattedContent;

        // Get related articles (excluding current article)
        $relatedArticles = Article::where('id', '!=', $id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return view('main.article.detailarticle', compact('article', 'relatedArticles'));
    }


    private function formatArticleContent($content)
    {
        // Remove any existing HTML formatting
        $plainText = strip_tags($content);

        // Split content into sentences (roughly)
        $sentences = preg_split('/(?<=[.!?])\s+/', $plainText, -1, PREG_SPLIT_NO_EMPTY);

        // Group sentences into paragraphs (about 3-4 sentences per paragraph)
        $paragraphs = [];
        $currentParagraph = [];
        $sentenceCount = 0;

        foreach ($sentences as $sentence) {
            $currentParagraph[] = $sentence;
            $sentenceCount++;

            // Create a new paragraph after every 3-4 sentences
            // You can adjust this number based on your preference
            if ($sentenceCount >= 3 && (strpos($sentence, '.') !== false)) {
                $paragraphs[] = implode(' ', $currentParagraph);
                $currentParagraph = [];
                $sentenceCount = 0;
            }
        }

        // Add any remaining sentences as the last paragraph
        if (!empty($currentParagraph)) {
            $paragraphs[] = implode(' ', $currentParagraph);
        }

        // Convert paragraphs array back to HTML with proper paragraph tags
        $formattedContent = '';
        foreach ($paragraphs as $index => $paragraph) {
            $formattedContent .= '<p class="mb-4">' . $paragraph . '</p>';
        }

        return $formattedContent;
    }

    /**
     * Menampilkan detail resep
     */
    public function show($id)
{
    $recipe = Recipe::with('category', 'reviews')->findOrFail($id);
    $reviews = Review::where('recipe_id', $id)
        ->with('user')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    // If recipe is free, show it directly
    if ($recipe->price == 0) {
        return view('main.Recipe.detail', compact('recipe', 'reviews'));
    }

    // If not logged in, redirect to login
    if (!Auth::check()) {
        return redirect()->route('user.login.form')
            ->with('error', 'Silakan login terlebih dahulu untuk melihat detail resep');
    }

    // Check purchase status
    $purchaseStatus = PaymentItemController::getUserPurchaseStatus($recipe->id);

    if ($purchaseStatus === 'approved') {
        // If approved, show recipe
        return view('main.Recipe.detail', compact('recipe', 'reviews'));
    } else if ($purchaseStatus === 'pending') {
        // If pending, redirect to payment status page
        return redirect()->route('payment.show', $recipe->id);
    } else {
        // If not purchased, redirect to checkout
        return redirect()->route('payment.checkout', ['id' => $recipe->id])
            ->with('info', 'Resep ini berbayar. Silakan lakukan pembayaran terlebih dahulu.');
    }
}

    public function filterByCategory($categoryId)
    {
        // Pastikan hanya pengguna yang sudah login yang dapat mengakses
        // if (!Auth::check()) {
        //     return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk mengakses katalog');
        // }

        // Validasi kategori
        $category = Category::findOrFail($categoryId);

        // Filter resep berdasarkan kategori
        $recipes = Recipe::with('category')
            ->where('category_id', $categoryId)
            ->latest()
            ->paginate(9);

        $categories = Category::all();

        return view('main.index', compact('recipes', 'categories', 'category'));
    }

    /**
     * Pencarian resep
     */
    public function search(Request $request)
    {
        // Pastikan hanya pengguna yang sudah login yang dapat mengakses
        // if (!Auth::check()) {
        //     return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk mengakses katalog');
        // }

        $query = $request->input('query');

        // Cari resep berdasarkan nama atau deskripsi
        $recipes = Recipe::with('category')
            ->where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->latest()
            ->paginate(9);

        $categories = Category::all();

        return view('main.index', compact('recipes', 'categories', 'query'));
    }

    /**
     * Ambil path gambar resep
     */
    public function getRecipeImagePath($imageName)
    {
        if (!$imageName) {
            return 'default-recipe.jpg';
        }

        $path = public_path('storage/recipes/' . $imageName);

        // Jika file persis tidak ditemukan, kembalikan default
        if (!file_exists($path)) {
            return 'default-recipe.jpg';
        }

        return $imageName;
    }

    /**
     * Halaman pembayaran resep
     */
    public function payment(string $id)
    {
        // Pastikan hanya pengguna yang sudah login yang dapat mengakses
        // if (!Auth::check()) {
        //     return redirect()->route('user.login.form')->with('error', 'Silakan login terlebih dahulu untuk melakukan pembayaran');
        // }

        $recipe = Recipe::findOrFail($id);

        return view('payment.index', compact('recipe'));
    }

    private function getRecipePurchaseStatus($recipeId, $userId)
    {
        // First check if recipe is free
        $recipe = Recipe::find($recipeId);
        if ($recipe->price == 0) {
            return 'Gratis';
        }

        // Check for any payment items for this recipe and user
        $paymentItem = PaymentItem::whereHas('payment', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->where('recipe_id', $recipeId)
        ->with('payment') // Eager load payment to check status
        ->first();

        // If no payment found, recipe is unpurchased
        if (!$paymentItem) {
            return 'unpurchased';
        }

        // Return status based on payment status
        return $paymentItem->payment->status; // 'approved', 'pending', or 'rejected'
    }
}
