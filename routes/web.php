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

    // Backend CRUD Routes
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
});

// Auction Routes
Route::get('/auctions', function () {
    return view('auctions.index');
})->name('auctions.index');

Route::get('/auctions/{auction}', function ($auction) {
    return view('auctions.show', compact('auction'));
})->name('auctions.show');

// Category Routes
Route::get('/categories', function () {
    return view('categories.index');
})->name('categories.index');

Route::get('/categories/{category}', function ($category) {
    return view('categories.show', compact('category'));
})->name('categories.show');

// Search Route
Route::get('/search', function () {
    return view('search.results');
})->name('search.results');

// How It Works Route
Route::get('/how-it-works', function () {
    return view('pages.how-it-works');
})->name('how-it-works');

require __DIR__.'/auth.php';