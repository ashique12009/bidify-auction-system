<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

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

// Backend CRUD Routes
Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);

require __DIR__.'/auth.php';
