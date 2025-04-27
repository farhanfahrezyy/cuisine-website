<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PaymentItem;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentItemController extends Controller
{
    public function index(Request $request)
{
    if (!Auth::check()) {
        return redirect()->route('user.login.form')
            ->with('error', 'Silakan login terlebih dahulu untuk melihat detail resep');
    }

    $query = Payment::query();

    // Filter berdasarkan status
    if ($request->has('status') && $request->status !== '') {
        $query->where('status', $request->status);
    }

    // Sort berdasarkan tanggal
    $sort = $request->sort ?? 'desc';
    $query->orderBy('created_at', $sort);

    // Pagination
    $perPage = $request->pagination ?? 10;

    // Search
    if ($request->search) {
        $query->where(function($q) use ($request) {
            $q->where('id', 'LIKE', "%{$request->search}%")
              ->orWhereHas('user', function($q) use ($request) {
                  $q->where('name', 'LIKE', "%{$request->search}%");
              });
        });
    }

    $payments = $query->paginate($perPage)->withQueryString();

    return view('admin.payments.index', compact('payments'));
}
    public function show($id)
    {
        if (!Auth::check()) {
            return redirect()->route('user.login.form')
                ->with('error', 'Silakan login terlebih dahulu untuk melihat detail resep');
        }
        // Check if the user has purchased the recipe and payment is approved
        $recipe = Recipe::findOrFail($id);

        $hasPurchased = PaymentItem::whereHas('payment', function($query) {
            $query->where('user_id', Auth::id())
                ->where('status', 'approved');
        })->where('recipe_id', $id)->exists();

        // If recipe is free or user has purchased it, show the recipe
        if ($recipe->price == 0 || $hasPurchased) {
            return view('main.recipe.detail', compact('recipe'));
        }

        // If recipe is paid and user hasn't purchased it, redirect to payment
        return redirect()->route('payment.checkout', ['id' => $id])
            ->with('info', 'Resep ini berbayar. Silakan lakukan pembayaran terlebih dahulu.');
    }

    // Method to check if user has purchased recipe (can be used in middleware or other controllers)
    public static function getUserPurchaseStatus($recipeId)
    {
        if (!Auth::check()) {
            return 'not_logged_in';
        }

        // Check for approved payment
        $approvedPayment = PaymentItem::whereHas('payment', function($query) {
            $query->where('user_id', Auth::id())
                  ->where('status', 'approved');
        })->where('recipe_id', $recipeId)->exists();

        if ($approvedPayment) {
            return 'approved';
        }

        // Check for pending payment
        $pendingPayment = PaymentItem::whereHas('payment', function($query) {
            $query->where('user_id', Auth::id())
                  ->where('status', 'pending');
        })->where('recipe_id', $recipeId)->exists();

        if ($pendingPayment) {
            return 'pending';
        }

        return 'not_purchased';
    }

    // Keep this method for backward compatibility
    public static function hasUserPurchased($recipeId)
    {
        return self::getUserPurchaseStatus($recipeId) === 'approved';
    }
}
