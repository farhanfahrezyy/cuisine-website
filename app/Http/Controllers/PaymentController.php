<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Recipe;
use App\Models\PaymentItem;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function index(Request $request)
    {

        $payments = Payment::where('user_id', Auth::id())
            ->orderBy('created_at', 'asc')
            ->paginate($request->input('pagination', 10));


        return view('main.payment.show', compact('payments'));
    }

    public function adminIndex()
    {
        $type_menu = 'payment';
        $perPage = request('pagination', 10);

        $paymentsQuery = Payment::query();

        // Status filter
        if (request()->has('status') && request('status') !== '') {
            $paymentsQuery->where('status', request('status'));
        }

        // Search functionality
        if (request()->has('search') && request('search') !== '') {
            $search = request('search');
            $paymentsQuery->where(function ($query) use ($search) {
                $query->where('id', 'like', "%{$search}%")
                    ->orWhere('total_amount', 'like', "%{$search}%");
            });
        }

        // Sort direction
        $sortDirection = request('sort', 'desc');
        $paymentsQuery->orderBy('created_at', $sortDirection);

        $payments = $paymentsQuery->paginate($perPage);

        return view('admin.payments.index', compact('payments', 'type_menu'));
    }
    // PaymentController.php
    public function showRecipePayment($id)
    {
        if (!Auth::check()) {
            return redirect()->route('user.login.form')
                ->with('error', 'Silakan login terlebih dahulu untuk melihat detail resep');
        }

        // $recipe = Recipe::findOrFail($id);
        // dd($recipe);


        $payment = Payment::whereHas('paymentItems', function ($query) use ($id) {
            $query->where('recipe_id', $id);
        })
            ->where('user_id', Auth::id())
            ->latest()
            ->first();

        // Jika payment tidak ditemukan, redirect atau tampilkan pesan
        if (!$payment) {
            return redirect()->route('recipes.show', $id)
                ->with('error', 'Pembayaran untuk resep ini tidak ditemukan.');
        }

        $paymentItems = PaymentItem::where('payment_id', $payment->id)
            ->with('recipe')
            ->get();

        // dd($paymentItems);
        return view('main.payment.show', compact('payment', 'paymentItems'));
    }
    public function checkout(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('user.login.form')
                ->with('error', 'Silakan login terlebih dahulu untuk melihat detail resep');
        }

        // $reviews = Review::where('recipe', $id)
        //     ->with('user')
        //     ->orderBy('created_at', 'desc')
        //     ->get();

        $recipe = Recipe::with('reviews')->findOrFail($id);
        // dd($recipe);

        $avgRating = number_format($recipe->reviews->avg('rating'));

        // dd($avgRating);

        return view('main.payment.checkout', compact('recipe', 'avgRating'));
    }

    public function process(Request $request)
    {
        try {
            // Validate incoming request
            $request->validate([
                'recipe_id' => 'required|exists:recipes,id',
                'payment_proof' => 'required|image|max:20480',
            ]);

            $recipe = Recipe::findOrFail($request->recipe_id);
            Log::info('Processing payment for recipe: ' . $recipe->id . ' - ' . $recipe->name);

            $adminFee = 2500;
            $totalAmount = $recipe->price + $adminFee;

            // Create a new Payment instance
            $payment = new Payment();
            $payment->user_id = Auth::id(); // Save user ID
            // $payment->no_tracking = date('YmdHis') . Str::random(5); // Generated tracking number
            $payment->status = 'Pending'; // Default status should be lowercase to match the validation in updateStatus
            $payment->total_amount = $totalAmount;

            // Handle payment proof upload
            if ($request->hasFile('payment_proof')) {
                $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
                $payment->payment_proof = $paymentProofPath; // Save the path
                Log::info('Payment proof saved at: ' . $paymentProofPath);
            }
            // dd($payment);
            // Save payment
            if (!$payment->save()) {
                Log::error('Failed to save payment');
                throw new \Exception('Failed to save payment');
            }

            Log::info('Payment saved with ID: ' . $payment->id);

            // After the payment has an ID, create a payment item
            $paymentItem = new PaymentItem();
            $paymentItem->payment_id = $payment->id; // Link to payment
            $paymentItem->recipe_id = $recipe->id; // Link to recipe
            // $paymentItem->price = $recipe->price; // Store price in payment item

            if (!$paymentItem->save()) {
                Log::error('Failed to save payment item');
                throw new \Exception('Failed to save payment item');
            }

            Log::info('Payment process completed successfully');

            return redirect()->to('/payment/view/' . $recipe->id)->with('success', 'Pembayaran telah diproses. Menunggu konfirmasi admin.');
            

        } catch (\Exception $e) {
            // Log errors
            Log::error('Payment processing error: ' . $e->getMessage());
            Log::error('Error occurred at: ' . $e->getFile() . ' line ' . $e->getLine());

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage())
                ->withInput();
            // return('error');
        }
    }

    public function uploadProof(Request $request, $id)
    {
        try {
            $request->validate([
                'payment_proof' => 'required|image|max:20480',
            ]);

            $payment = Payment::where('id', $id)
                ->where('user_id', Auth::id())
                ->where('status', 'pending')
                ->firstOrFail();

            // Delete old proof if exists
            if ($payment->payment_proof && Storage::disk('public')->exists($payment->payment_proof)) {
                Storage::disk('public')->delete($payment->payment_proof);
            }

            // Upload payment proof
            $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');

            // Update payment
            $payment->payment_proof = $paymentProofPath;

            if (!$payment->save()) {
                throw new \Exception('Failed to save payment proof');
            }

            return redirect()->route('payment.show', $payment->id)
                ->with('success', 'Bukti pembayaran berhasil diunggah.');
        } catch (\Exception $e) {
            Log::error('Upload proof error: ' . $e->getMessage());
            Log::error('Error occurred at: ' . $e->getFile() . ' line ' . $e->getLine());

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengunggah bukti pembayaran: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function adminShow($id)
    {
        $type_menu = 'payment';

        $payment = Payment::with('user')->findOrFail($id);
        $paymentItems = PaymentItem::where('payment_id', $payment->id)
            ->with('recipe')
            ->get();

        return view('admin.payments.show', compact('payment', 'paymentItems', 'type_menu'));
    }

    public function updateStatus(Request $request, $id)
    {


        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $payment = Payment::findOrFail($id);
        $payment->status = $request->status;

        if (!$payment->save()) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui status pembayaran.');
        }

        return redirect()->route('admin.payments.show', $payment->id)
            ->with('success', 'Status pembayaran berhasil diperbarui.');
    }
}
