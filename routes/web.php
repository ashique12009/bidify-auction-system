<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Dashboard Route (for login redirect)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// Profile Routes
Route::middleware('auth')->prefix('dashboard')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Routes - Full access to categories
    Route::middleware('role:admin')->group(function () {
        Route::resource('categories', CategoryController::class);
    });

    // Publisher Routes - Can manage their own products only
    Route::middleware('role:publisher')->prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('products.index');
        Route::get('/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/', [ProductController::class, 'store'])->name('products.store');
        Route::get('/{product}', [ProductController::class, 'show'])->name('products.show');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::patch('/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    });

    // Admin Routes - Full access to all products
    Route::middleware('role:admin')->prefix('admin/products')->group(function () {
        Route::get('/', [ProductController::class, 'adminIndex'])->name('admin.products.index');
        Route::get('/{product}', [ProductController::class, 'show'])->name('admin.products.show');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    });
});

// FRONTEND ROUTES
// Auction Routes
Route::get('/auctions', [WelcomeController::class, 'auctions'])->name('auctions.index');

Route::get('/auctions/{auction}', [WelcomeController::class, 'auction'])->name('auctions.show');

// Category Routes
Route::get('/categories', [WelcomeController::class, 'categories'])->name('frontend.categories.index');

Route::get('/categories/{category}', [WelcomeController::class, 'category'])->name('frontend.categories.show');

// Search Route
Route::get('/search', [WelcomeController::class, 'search'])->name('search.results');

// How It Works Route
Route::get('/how-it-works', [WelcomeController::class, 'howItWorks'])->name('how-it-works');

require __DIR__.'/auth.php';