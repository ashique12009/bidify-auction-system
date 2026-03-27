@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Category Header -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="row g-0">
                    <div class="col-md-3">
                        @if($category->category_image)
                            <img src="{{ asset('storage/' . $category->category_image) }}" 
                                 alt="{{ $category->category_name }}" class="img-fluid rounded-start h-100" style="object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center h-100 rounded-start" style="min-height: 200px;">
                                <i class="fas fa-folder fa-3x text-muted"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-9">
                        <div class="card-body">
                            <h1 class="card-title">{{ $category->category_name }}</h1>
                            <p class="card-text text-muted">
                                Browse all auctions in the {{ $category->category_name }} category
                            </p>
                            <div class="d-flex align-items-center gap-3">
                                <span class="badge bg-primary fs-6">{{ $category->products_count ?? 0 }} Auctions</span>
                                @if($category->products_count > 0)
                                    <span class="text-muted">Active auctions available</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Filter Auctions</h5>
                    <form action="{{ route('categories.show', $category) }}" method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="running" {{ request('status') == 'running' ? 'selected' : '' }}>Running</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="ended" {{ request('status') == 'ended' ? 'selected' : '' }}>Ended</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Sort By</label>
                            <select name="sort" class="form-select">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="ending_soon" {{ request('sort') == 'ending_soon' ? 'selected' : '' }}>Ending Soon</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Price Range</label>
                            <div class="input-group">
                                <input type="number" name="min_price" class="form-control" placeholder="Min" value="{{ request('min_price') }}">
                                <span class="input-group-text">-</span>
                                <input type="number" name="max_price" class="form-control" placeholder="Max" value="{{ request('max_price') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Apply Filters</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Auctions Grid -->
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Auctions in {{ $category->category_name }}</h4>
                <span class="text-muted">{{ $products->count() }} of {{ $products->total() }} results</span>
            </div>
            
            <div class="row" id="auctions-grid">
                @forelse($products as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="auction-image">
                                <img src="{{ $product->product_image ? asset('storage/' . $product->product_image) : asset('images/default-auction.jpg') }}" 
                                     alt="{{ $product->product_name }}" class="card-img-top">
                                <span class="badge bg-{{ $product->status == 'running' ? 'danger' : 'warning' }} position-absolute top-0 start-0 m-2">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->product_name }}</h5>
                                <p class="card-text text-muted small">{{ Str::limit($product->description, 100) }}</p>
                                
                                <div class="bid-info mb-3">
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted small">Current Bid:</span>
                                        <span class="fw-bold text-primary">${{ number_format($product->current_price, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted small">Bids:</span>
                                        <span class="fw-bold">{{ $product->bids_count ?? 0 }}</span>
                                    </div>
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <a href="{{ route('auctions.show', $product) }}" class="btn btn-primary btn-sm">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <h3>No Auctions Found</h3>
                            <p class="text-muted">
                                @if(request()->hasAny(['status', 'sort', 'min_price', 'max_price']))
                                    Try adjusting your filters or 
                                    <a href="{{ route('categories.show', $category) }}">clear all filters</a>
                                @else
                                    There are no auctions in this category yet.
                                @endif
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            @if($products->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
