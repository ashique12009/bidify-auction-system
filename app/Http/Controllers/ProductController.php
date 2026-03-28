<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller {
  /**
   * Display a listing of the resource.
   */
  public function index() {
    // For publishers, show only their own products
    if (auth()->user()->role === 'publisher') {
      $products = Product::with(['category', 'publisher'])
          ->where('publisher_id', auth()->id())
          ->latest()
          ->paginate(10);
    } else {
      // For admins, show all products
      $products = Product::with(['category', 'publisher'])->latest()->paginate(10);
    }
        
    return view('backend.products.index', compact('products'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create() {
    $categories = Category::all();
    return view('backend.products.create', compact('categories'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request) {
    $request->validate([
      'category_id'   => 'required|exists:categories,id',
      'product_name'  => 'required|string|max:255',
      'description'   => 'nullable|string',
      'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
      'status'        => 'required|in:pending,running,ended',
      'start_price'   => 'required|numeric|min:0',
      'current_price' => 'required|numeric|min:0',
      'start_time'    => 'nullable|date',
      'end_time'      => 'nullable|date|after:start_time',
    ]);

    $data = $request->except('product_image');
    $data['publisher_id'] = auth()->id();

    if ($request->hasFile('product_image')) {
      $image = $request->file('product_image');
      $imageName = 'products/' . time() . '.' . $image->getClientOriginalExtension();
      Storage::disk('public')->put($imageName, $image->get());
      $data['product_image'] = $imageName;
    }

    Product::create($data);

    return redirect()->route('products.index')
        ->with('success', 'Product created successfully.');
  }

  /**
   * Display the specified resource.
   */
  public function show(Product $product) {
    $product->load(['category', 'publisher']);
    return view('backend.products.show', compact('product'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Product $product) {
    // Check if user is publisher and owns this product, or if user is admin
    if (auth()->user()->role === 'publisher' && $product->publisher_id !== auth()->id()) {
      return redirect()->route('products.index')->with('error', 'You can only edit your own products.');
    }
        
    $categories = Category::all();
    return view('backend.products.edit', compact('product', 'categories'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Product $product) {
    // Check if user is publisher and owns this product, or if user is admin
    if (auth()->user()->role === 'publisher' && $product->publisher_id !== auth()->id()) {
      return redirect()->route('products.index')->with('error', 'You can only update your own products.');
    }
    $request->validate([
      'category_id'   => 'required|exists:categories,id',
      'product_name'  => 'required|string|max:255',
      'description'   => 'nullable|string',
      'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
      'status'        => 'required|in:pending,running,ended',
      'start_price'   => 'required|numeric|min:0',
      'current_price' => 'required|numeric|min:0',
      'start_time'    => 'nullable|date',
      'end_time'      => 'nullable|date|after:start_time',
    ]);

    $data = $request->except('product_image');

    if ($request->hasFile('product_image')) {
      // Delete old image if exists
      if ($product->product_image && Storage::disk('public')->exists($product->product_image)) {
        Storage::disk('public')->delete($product->product_image);
      }

      $image = $request->file('product_image');
      $imageName = 'products/' . time() . '.' . $image->getClientOriginalExtension();
      Storage::disk('public')->put($imageName, file_get_contents($image));
      $data['product_image'] = $imageName;
    }

    $product->update($data);

    return redirect()->route('products.index')
        ->with('success', 'Product updated successfully.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Product $product) {
    // Check if user is publisher and owns this product, or if user is admin
    if (auth()->user()->role === 'publisher' && $product->publisher_id !== auth()->id()) {
      return redirect()->route('products.index')->with('error', 'You can only delete your own products.');
    }
        
    // Delete image if exists
    if ($product->product_image && Storage::disk('public')->exists($product->product_image)) {
      Storage::disk('public')->delete($product->product_image);
    }

    $product->delete();

    return redirect()->route('products.index')
        ->with('success', 'Product deleted successfully.');
  }
}
