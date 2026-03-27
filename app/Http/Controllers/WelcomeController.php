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
}
