<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Payment;
use App\Models\PaymentItem;
use Illuminate\Support\Facades\Auth;

class PurchasedRecipeController extends Controller
{
    /**
     * Display a listing of purchased recipes.
     *
     * @return \Illuminate\Http\Response
     */
        // Get the current user
        public function index()
    {
        // Get the current user
        $user = Auth::user();



        // Get completed payments for this user
        $completedPaymentIds = Payment::where('user_id', $user->id)
            ->where('status', 'approved')
            ->pluck('id');

        // Get recipe IDs from payment items
        $purchasedRecipeIds = PaymentItem::whereIn('payment_id', $completedPaymentIds)
            ->pluck('recipe_id')
            ->unique();

        $purchaseCount = $purchasedRecipeIds->count();
        // Get the recipe details with pagination
        // Note: We need to use paginate() on the query builder, not on a collection
        $recipes = Recipe::whereIn('id', $purchasedRecipeIds)
                        ->with('reviews')  // Eager load reviews for rating calculation
                        ->paginate(9);     // Use paginate() to create a LengthAwarePaginator

        return view('main.Recipe.myrecipe', compact('recipes', 'purchaseCount'));
    }
}
