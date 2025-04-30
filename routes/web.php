<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentItemController;
use App\Http\Controllers\PurchasedRecipeController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthControllers;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecipeReviewController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserPreferenceController;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Termwind\Components\Hr;

Route::get('/recipes', [Controller::class, 'index']);
// Route::get('/php', function () {
//     dd(phpinfo());
// })->name('php.info');

Route::prefix('admin')->name('admin.')->middleware(['preventBackHistory'])->group(function () {
    // Public routes (tidak memerlukan auth)
    Route::middleware(['guest:admin'])->group(function () {
        Route::get('/login', [AuthControllers::class, 'showAdminLoginForm'])->name('login');
        Route::post('/login', [AuthControllers::class, 'loginAdmin'])->name('submit.login');
        Route::post('/logout', [AuthControllers::class, 'logout'])->name('logout');
    });

    // Protected routes (memerlukan auth dan role admin)
    Route::middleware(['checkRole', 'preventBackHistory'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Recipe routes
        Route::prefix('/recipes')->name('recipes.')->group(function () {
            Route::get('/', [RecipeController::class, 'index'])->name('index');
            Route::get('/create', [RecipeController::class, 'create'])->name('create');
            Route::post('/store', [RecipeController::class, 'store'])->name('store');
            Route::get('/{recipe}/edit', [RecipeController::class, 'edit'])->name('edit');
            Route::put('/{recipe}', [RecipeController::class, 'update'])->name('update');
            Route::delete('/{recipe}', [RecipeController::class, 'destroy'])->name('destroy');
        });

        //Article routes
        Route::prefix('/articles')->name('articles.')->group(function () {
            Route::get('/', [ArticleController::class, 'index'])->name('index');
            Route::get('/create', [ArticleController::class, 'create'])->name('create');
            Route::post('/store', [ArticleController::class, 'store'])->name('store');
            Route::get('/{article}/edit', [ArticleController::class, 'edit'])->name('edit');
            Route::put('/{article}', [ArticleController::class, 'update'])->name('update');
            Route::delete('/{article}', [ArticleController::class, 'destroy'])->name('destroy');
        });

        // Payment routes
        Route::prefix('/payments')->name('payments.')->group(function () {
            Route::get('/', [PaymentController::class, 'adminIndex'])->name('index');
            Route::get('/payment/{id}', [App\Http\Controllers\PaymentController::class, 'adminShow'])->name('show');
            Route::post('/payment/{id}/update-status', [App\Http\Controllers\PaymentController::class, 'updateStatus'])->name('update-status');
            Route::get('/create', [PaymentController::class, 'create'])->name('create');
            Route::post('/store', [PaymentController::class, 'store'])->name('store');
            Route::get('/{payment}/edit', [PaymentController::class, 'edit'])->name('edit');
            Route::put('/{payment}', [PaymentController::class, 'update'])->name('update');
            Route::delete('/{payment}', [PaymentController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('/reviews')->name('reviews.')->group(function () {
            Route::get('/', [ReviewController::class, 'index'])->name('index');
            Route::get('/create', [ReviewController::class, 'create'])->name('create');
            Route::post('/store', [ReviewController::class, 'store'])->name('store');
            Route::get('/recipe/{recipe_id}', [ReviewController::class, 'show'])->name('show');
            Route::delete('/{recipe_id}/{review_id}', [ReviewController::class, 'destroy'])->name('destroy');
        });
    });
});
Route::prefix('user')->name('user.')->middleware(['preventBackHistory', 'BlockAdminAccess'])->group(function () {
    // Route publik (login, register)
    Route::middleware(['guest:web'])->group(function () {
        Route::get('/login', [AuthControllers::class, 'showLoginForm'])->name('login.form');
        Route::get('/register', [AuthControllers::class, 'showRegisterForm'])->name('register.form');
        Route::post('/register', [AuthControllers::class, 'register'])->name('register.submit');
        Route::post('/login', [AuthControllers::class, 'login'])->name('login.submit');
    });

    // Route yang membutuhkan auth
    Route::middleware(['auth:web'])->group(function () {
        Route::get('/dashboard', [AuthControllers::class, 'dashboard'])->name('dashboard');
        Route::get('/recommendations', [RecommendationController::class, 'index'])->name('recommendations.index');
        Route::get('/myrecipe', [PurchasedRecipeController::class, 'index'])->name('myrecipes.index');
        Route::get('/preferences', function () {
            return view('main.home');
        })->name('user-p');
        Route::post('/preferences', [UserPreferenceController::class, 'store'])->name('preferences.store');
        Route::post('/logout', [AuthControllers::class, 'logout'])->name('logout');
    });
});
// Route::middleware('preventBackHistory', 'BlockAdminAccess')->group(function () {});

Route::middleware('BlockAdminAccess', 'preventBackHistory')->group(function () {

    Route::prefix('/recipes')->name('recipes.')->group(function () {
        Route::get('/recipes/{id}', [CatalogController::class, 'show'])
            ->name('show')
            ->where('id', '[0-9]+'); // Optional: ensure id is numeric;
    });


    Route::middleware(['auth:web'])->group(function () {
        // User payment routes
        Route::get('/main/payments', [App\Http\Controllers\PaymentController::class, 'index'])->name('payment.index');
        Route::get('/payment/view/{id}', [App\Http\Controllers\PaymentController::class, 'showRecipePayment'])->name('payment.show');
        Route::get('/payment/checkout/{id?}', [App\Http\Controllers\PaymentController::class, 'checkout'])->name('payment.checkout');
        Route::post('payment/process', [App\Http\Controllers\PaymentController::class, 'process'])->name('payment.process');
        Route::post('/payment/{id}/upload-proof', [App\Http\Controllers\PaymentController::class, 'uploadProof'])->name('payment.upload-proof');

        // User purchased recipes
        Route::get('/my-recipes', [App\Http\Controllers\PaymentItemController::class, 'index'])->name('payment-item.index');
        Route::get('/recipe/view/{id}', [App\Http\Controllers\PaymentItemController::class, 'show'])->name('recipe.view');

        Route::post('/recipes/{recipeId}/reviews', [RecipeReviewController::class, 'store'])->name('recipe.reviews.store');
        Route::delete('/reviews/{reviewId}', [RecipeReviewController::class, 'destroy'])->name('recipe.reviews.destroy');
    });

    Route::get('/recipes/{recipeId}/reviews', [RecipeReviewController::class, 'index'])->name('recipe.reviews.index');
    // This is the correct route for showing the articles list
    Route::get('/articles', [CatalogController::class, 'article'])->name('articles');

    // This is the correct route for showing a single article
    Route::get('/articles/{id}', [CatalogController::class, 'articleshow'])
        ->name('articles.show')
        ->where('id', '[0-9]+');
    Route::get('/', [CatalogController::class, 'index'])->name('index');

    Route::get('/', [CatalogController::class, 'index'])->name('home');
    Route::get('/search', [HomeController::class, 'search'])->name('recipes.search');
    Route::get('/search/{query}', [HomeController::class, 'searchReccomendation'])->name('recipes.search.reccomendation');
    Route::get('/cuisine/{cuisine}', [HomeController::class, 'cuisine'])->name('recipes.cuisine');
    Route::get('/premium/{cuisine}', [HomeController::class, 'premium'])->name('recipes.premium');

    // Admin payment routes (add middleware for admin only)
    Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
        // Route::get('/payments', [App\Http\Controllers\PaymentController::class, 'adminIndex'])->name('admin.payment.index');
        // Route::get('/payment/{id}', [App\Http\Controllers\PaymentController::class, 'adminShow'])->name('admin.payment.show');

    });
    Route::get('/my-recipes', [PaymentItemController::class, 'index'])->name('payment.items.index');



    Route::get('/register', function () {
        return view('auth.register');
    })->name('register')->middleware('guest');


    Route::get('/about', function () {
        return view('main.about');
    })->name('about');

    Route::get('/contact', function () {
        return view('main.contact');
    })->name('contact');
});
