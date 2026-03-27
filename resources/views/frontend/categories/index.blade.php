@extends('layouts.frontend-layout')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1>Browse Categories</h1>
            <p class="text-muted">Explore auctions by category</p>
        </div>
    </div>
    
    <div class="row">
        <!-- Category Grid -->
        <div class="col-md-12">
            <div class="row" id="categories-grid">
                @forelse($categories ?? [] as $category)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 category-card">
                            <div class="category-image">
                                @if($category->category_image)
                                    <img src="{{ asset('storage/' . $category->category_image) }}" 
                                         alt="{{ $category->category_name }}" class="card-img-top">
                                @else
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <i class="fas fa-folder fa-3x text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $category->category_name }}</h5>
                                <p class="card-text text-muted">
                                    {{ $category->products_count ?? 0 }} active auctions
                                </p>
                                <div class="d-grid">
                                    <a href="{{ route('categories.show', $category) }}" class="btn btn-outline-primary">
                                        Browse Auctions
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <h3>No Categories Available</h3>
                            <p class="text-muted">Categories will appear here once they are created</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Featured Categories -->
    @if(isset($featuredCategories) && $featuredCategories->count() > 0)
        <div class="row mt-5">
            <div class="col-md-12">
                <h2 class="mb-4">Featured Categories</h2>
                <div class="row">
                    @foreach($featuredCategories as $category)
                        <div class="col-md-6 mb-4">
                            <div class="card featured-category">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        @if($category->category_image)
                                            <img src="{{ asset('storage/' . $category->category_image) }}" 
                                                 alt="{{ $category->category_name }}" class="img-fluid rounded-start h-100" style="object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center h-100 rounded-start">
                                                <i class="fas fa-star fa-2x text-muted"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $category->category_name }}</h5>
                                            <p class="card-text text-muted">
                                                {{ $category->products_count ?? 0 }} auctions available
                                            </p>
                                            <a href="{{ route('categories.show', $category) }}" class="btn btn-sm btn-primary">
                                                View Auctions
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
