<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\RecipeReview;
use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;

class RecipeReviewController extends Controller
{
    /**
     * Store a new review for a recipe
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $recipeId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $recipeId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // Check if recipe exists
        $recipe = Recipe::findOrFail($recipeId);

        // Check if user already reviewed this recipe
        $existingReview = Review::where('user_id', Auth::id())
            ->where('recipe_id', $recipeId)
            ->first();


        if ($existingReview) {
            // Update existing review
            $existingReview->rating = $request->rating;
            $existingReview->comment = $request->comment;
            $existingReview->save();

            return redirect()->back()->with('success', 'Your review has been updated!');
        }

        // Create new review
        Review::create([
            'user_id' => Auth::id(),
            'recipe_id' => $recipeId,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return redirect()->back()->with('success', 'Thank you for your review!');
    }

    /**
     * Display recipe reviews
     *
     * @param  int  $recipeId
     * @return \Illuminate\View\View
     */
    public function index($recipeId)
    {
        $recipe = Recipe::findOrFail($recipeId);
        $reviews = Review::where('recipe_id', $recipeId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('main.recipe.detail', compact('recipe', 'reviews'));
    }

    /**
     * Delete a review
     *
     * @param  int  $reviewId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($reviewId)
    {
        $review = Review::findOrFail($reviewId);

        // Check if user owns this review or is admin
        // if ($review->user_id !== Auth::id() && !Auth::user()-> role !== 'admin') {
        //     return redirect()->back()->with('error', 'You are not authorized to delete this review.');
        // }

        $review->delete();
        return redirect()->back()->with('success', 'Review has been deleted!');
    }
}
