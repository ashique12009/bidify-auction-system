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
Route::get('/auctions', function () {
    $auctions = \App\Models\Product::with(['category', 'publisher'])
        ->where('status', 'running')
        ->latest()
        ->paginate(12);
    return view('frontend.auctions.index', compact('auctions'));
})->name('auctions.index');

Route::get('/auctions/{auction}', function ($auction) {
    $auction = \App\Models\Product::with(['category', 'publisher', 'bids.user'])
        ->findOrFail($auction);
    return view('frontend.auctions.show', compact('auction'));
})->name('auctions.show');

// Category Routes
Route::get('/categories', function () {
    $categories = \App\Models\Category::withCount('products')->get();
    $featuredCategories = \App\Models\Category::withCount('products')
        ->where('products_count', '>', 0)
        ->take(6)
        ->get();
    return view('frontend.categories.index', compact('categories', 'featuredCategories'));
})->name('frontend.categories.index');

Route::get('/categories/{category}', function ($category) {
    $category = \App\Models\Category::withCount('products')->findOrFail($category);
    
    $query = \App\Models\Product::with(['category', 'publisher'])
        ->where('category_id', $category->id);
    
    // Apply filters
    if (request('status')) {
        $query->where('status', request('status'));
    }
    
    if (request('min_price')) {
        $query->where('current_price', '>=', request('min_price'));
    }
    
    if (request('max_price')) {
        $query->where('current_price', '<=', request('max_price'));
    }
    
    // Apply sorting
    switch (request('sort')) {
        case 'price_low':
            $query->orderBy('current_price', 'asc');
            break;
        case 'price_high':
            $query->orderBy('current_price', 'desc');
            break;
        case 'ending_soon':
            $query->orderBy('end_time', 'asc');
            break;
        default:
            $query->latest();
    }
    
    $products = $query->paginate(12);
    return view('frontend.categories.show', compact('category', 'products'));
})->name('categories.show');

// Search Route
Route::get('/search', function () {
    $query = \App\Models\Product::with(['category', 'publisher']);
    
    // Search by keyword
    if (request('q')) {
        $query->where(function($q) {
            $q->where('product_name', 'like', '%' . request('q') . '%')
              ->orWhere('description', 'like', '%' . request('q') . '%');
        });
    }
    
    // Apply filters
    if (request('category_id')) {
        $query->where('category_id', request('category_id'));
    }
    
    if (request('status')) {
        $query->where('status', request('status'));
    }
    
    if (request('min_price')) {
        $query->where('current_price', '>=', request('min_price'));
    }
    
    if (request('max_price')) {
        $query->where('current_price', '<=', request('max_price'));
    }
    
    // Apply sorting
    switch (request('sort')) {
        case 'price_low':
            $query->orderBy('current_price', 'asc');
            break;
        case 'price_high':
            $query->orderBy('current_price', 'desc');
            break;
        case 'ending_soon':
            $query->orderBy('end_time', 'asc');
            break;
        case 'relevance':
        default:
            if (request('q')) {
                // Relevance: prioritize exact matches in title
                $query->orderByRaw("CASE 
                    WHEN product_name LIKE ? THEN 1 
                    WHEN product_name LIKE ? THEN 2 
                    WHEN description LIKE ? THEN 3 
                    ELSE 4 END", 
                    [request('q'), '%' . request('q') . '%', '%' . request('q') . '%']);
            }
            $query->latest();
    }
    
    $products = $query->paginate(12);
    
    // Get categories for filter dropdown
    $categories = \App\Models\Category::all();
    
    // Generate search suggestions (optional)
    $suggestions = [];
    if (request('q') && $products->isEmpty()) {
        $suggestions = ['Electronics', 'Fashion', 'Art', 'Jewelry', 'Watches'];
    }
    
    return view('frontend.search.results', compact('products', 'categories', 'suggestions'));
})->name('search.results');

// How It Works Route
Route::get('/how-it-works', function () {
    return view('frontend.pages.how-it-works');
})->name('how-it-works');

require __DIR__.'/auth.php';