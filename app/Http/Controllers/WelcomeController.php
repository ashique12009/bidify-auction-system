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
}
