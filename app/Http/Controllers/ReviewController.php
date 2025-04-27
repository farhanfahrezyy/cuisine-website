<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Review;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request){

        $type_menu = 'review';

        // Get products with reviews, calculate average rating, and apply filters if needed
        $recipesWithReviews = Recipe::whereHas('reviews')
            ->withAvg('reviews', 'rating') // Calculate the average rating for each product
            ->when($request->input('name'), function($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->paginate(10); // Paginate the results, 10 products per page

        return view('admin.reviews.index', compact('recipesWithReviews', 'type_menu'));

    }

    public function show($recipe_id)
{
    $type_menu = 'review';

    // Load recipe with its reviews
    $recipe = Recipe::with('reviews')
        ->findOrFail($recipe_id);

    // Menampilkan data resep dan review terkait di view
    return view('admin.reviews.show', compact('recipe', 'type_menu'));
}

    public function destroy($recipe_id, $review_id)
    {
        // Find the review by ID and delete it
        $review = Review::where('id', $review_id)->where('recipe_id', $recipe_id)->firstOrFail();
        $review->delete();

        // Redirect back to the reviews page with a success message
        return redirect()->route('admin.reviews.show', $recipe_id)->with('success', 'Review berhasil dihapus.');
    }




}
