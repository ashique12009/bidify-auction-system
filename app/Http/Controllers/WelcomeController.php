<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Display the welcome page with latest categories and products.
     */
    public function index()
    {
        // Get latest 4 categories
        $categories = Category::latest()->take(4)->get();
        
        // Get latest 4 products with category and publisher relationships
        $products = Product::with(['category', 'publisher'])
            ->latest()
            ->take(4)
            ->get();
        
        return view('welcome', compact('categories', 'products'));
    }

    /**
     * Display the auctions page.
     */
    public function auctions()
    {
        $products = Product::with(['category', 'publisher'])
            ->latest()
            ->paginate(12);
        return view('frontend.auctions.index', compact('products'));
    }

    /**
     * Display the auction detail page.
     */
    public function auction($auction)
    {
        $auction = Product::with(['category', 'publisher', 'bids.user'])
            ->findOrFail($auction);
        return view('frontend.auctions.show', compact('auction'));
    }

    /**
     * Display the categories page.
     */
    public function categories()
    {
        $categories = \App\Models\Category::withCount('products')->get();
        $featuredCategories = \App\Models\Category::withCount('products')
            ->where('products_count', '>', 0)
            ->take(6)
            ->get();
        return view('frontend.categories.index', compact('categories', 'featuredCategories'));
    }

    /**
     * Display the category page.
     */
    public function category($category)
    {
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
    }

    /**
     * Display the how it works page.
     */
    public function howItWorks()
    {
        return view('frontend.pages.how-it-works');
    }
    
    public function search()
    {
        $query = Product::with(['category', 'publisher']);
    
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
        $categories = Category::all();
        
        // Generate search suggestions (optional)
        $suggestions = [];
        if (request('q') && $products->isEmpty()) {
            $suggestions = ['Electronics', 'Fashion', 'Art', 'Jewelry', 'Watches'];
        }
        
        return view('frontend.search.results', compact('products', 'categories', 'suggestions'));
    }
}
