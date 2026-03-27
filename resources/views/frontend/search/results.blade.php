@extends('layouts.frontend-layout')

@section('content')
<div class="container py-4">
    <!-- Search Header -->
    <div class="row mb-4">
        <div class="col-md-12">
            <h1>Search Results</h1>
            <p class="text-muted">
                @if(request('q'))
                    Found {{ $products->count() }} results for "<strong>{{ request('q') }}</strong>"
                @else
                    Browse all auctions
                @endif
            </p>
        </div>
    </div>
    
    <!-- Search Form -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('search.results') }}" method="GET" class="row g-3">
                        <div class="col-md-8">
                            <input type="text" name="q" class="form-control" 
                                   placeholder="Search for auctions..." value="{{ request('q') }}">
                        </div>
                        <div class="col-md-4">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Advanced Filters -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Advanced Filters</h5>
                    <form action="{{ route('search.results') }}" method="GET" class="row g-3">
                        <input type="hidden" name="q" value="{{ request('q') }}">
                        
                        <div class="col-md-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-select">
                                <option value="">All Categories</option>
                                @if(isset($categories))
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        
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
                                <option value="relevance" {{ request('sort') == 'relevance' ? 'selected' : '' }}>Relevance</option>
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="ending_soon" {{ request('sort') == 'ending_soon' ? 'selected' : '' }}>Ending Soon</option>
                            </select>
                        </div>
                        
                        <div class="col-md-3">
                            <label class="form-label">Price Range</label>
                            <div class="input-group">
                                <input type="number" name="min_price" class="form-control" placeholder="Min" value="{{ request('min_price') }}">
                                <span class="input-group-text">-</span>
                                <input type="number" name="max_price" class="form-control" placeholder="Max" value="{{ request('max_price') }}">
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Apply Filters</button>
                                <a href="{{ route('search.results') }}?q={{ request('q') }}" class="btn btn-outline-secondary">Clear Filters</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Results -->
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>
                    @if(request('q'))
                        Results for "{{ request('q') }}"
                    @else
                        All Auctions
                    @endif
                </h4>
                <span class="text-muted">
                    {{ $products->count() }} of {{ $products->total() }} results
                    @if(request()->hasAny(['category_id', 'status', 'sort', 'min_price', 'max_price']))
                        (filtered)
                    @endif
                </span>
            </div>
            
            <div class="row" id="search-results">
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
                                        <span class="text-muted small">Category:</span>
                                        <span class="badge bg-light text-dark">{{ $product->category->category_name }}</span>
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
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <h3>No Results Found</h3>
                            <p class="text-muted">
                                @if(request('q'))
                                    We couldn't find any auctions matching "<strong>{{ request('q') }}</strong>"
                                    <br>Try different keywords or 
                                    <a href="{{ route('search.results') }}">browse all auctions</a>
                                @else
                                    No auctions found with the current filters.
                                    <br><a href="{{ route('search.results') }}?q={{ request('q') }}">Clear filters</a> to see more results.
                                @endif
                            </p>
                            
                            <!-- Search Suggestions -->
                            @if(request('q') && isset($suggestions))
                                <div class="mt-4">
                                    <h5>Try searching for:</h5>
                                    <div class="d-flex flex-wrap gap-2 justify-content-center">
                                        @foreach($suggestions as $suggestion)
                                            <a href="{{ route('search.results') }}?q={{ urlencode($suggestion) }}" 
                                               class="btn btn-outline-secondary btn-sm">
                                                {{ $suggestion }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
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
