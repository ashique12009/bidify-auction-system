<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Bidify - Online Auction Platform') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="icon" href="favicon1.ico" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/frontend-style.css') }}">
    @vite(['resources/js/app.js'])
  </head>
  <body>
    <!-- Header -->
    <header class="header">
      <div class="container header-content">
        <a href="{{ route('welcome') }}" class="logo"><img src="{{ asset('assets/images/mlogo.jpg') }}" alt="Bidify Logo"></a>
        <nav class="nav">
          <a href="{{ route('welcome') }}">Home</a>
          <a href="{{ route('auctions.index') }}">Auctions</a>
          <a href="{{ route('frontend.categories.index') }}">Categories</a>
          <a href="{{ route('how-it-works') }}">How It Works</a>
        </nav>
        <div class="header-actions">
          <a href="{{ route('login') }}" class="btn btn-outline">Sign In</a>
          <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
        </div>
      </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
      <div class="container">
        <h1>Find & Bid on Unique Items</h1>
        <p>Discover rare collectibles, antiques, and exclusive products at unbeatable prices.</p>
        <form class="search-box" action="{{ route('search.results') }}" method="GET">
          <input
            type="text"
            name="q"
            value="{{ request('q') }}"
            placeholder="Search for items..."
          >
          <button type="submit" class="btn btn-primary">Search</button>
        </form>
      </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
      <div class="container stats-grid">
        <div class="stat-item">
          <span class="stat-number">12,500+</span>
          <span class="stat-label">Active Auctions</span>
        </div>
        <div class="stat-item">
          <span class="stat-number">45,000+</span>
          <span class="stat-label">Registered Users</span>
        </div>
        <div class="stat-item">
          <span class="stat-number">$2.5M+</span>
          <span class="stat-label">Items Sold</span>
        </div>
        <div class="stat-item">
          <span class="stat-number">98%</span>
          <span class="stat-label">Happy Buyers</span>
        </div>
      </div>
    </section>

    <!-- Featured Auctions -->
    <section class="featured">
      <div class="container">
        <div class="section-header">
          <h2>Featured Auctions</h2>
          <a href="#" class="view-all">View All →</a>
        </div>
        
        <div class="auction-grid">
          <!-- Auction Card 1 -->
          <div class="auction-card">
            <div class="auction-image">
              <span class="badge live">Live</span>
              <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=300&fit=crop" alt="Vintage Watch">
            </div>
            <div class="auction-details">
              <h3>Vintage Rolex Submariner 1960</h3>
              <div class="bid-info">
                <div>
                  <span class="label">Current Bid</span>
                  <span class="price">$4,250</span>
                </div>
                <div>
                  <span class="label">Time Left</span>
                  <span class="time">2h 15m</span>
                </div>
              </div>
              <div class="bid-count">23 bids</div>
              <button class="btn btn-primary btn-full">Place Bid</button>
            </div>
          </div>

          <!-- Auction Card 2 -->
          <div class="auction-card">
            <div class="auction-image">
              <span class="badge hot">Hot</span>
              <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&h=300&fit=crop" alt="Art Painting">
            </div>
            <div class="auction-details">
              <h3>Original Oil Painting - Sunset</h3>
              <div class="bid-info">
                <div>
                  <span class="label">Current Bid</span>
                  <span class="price">$1,800</span>
                </div>
                <div>
                  <span class="label">Time Left</span>
                  <span class="time">5h 42m</span>
                </div>
              </div>
              <div class="bid-count">15 bids</div>
              <button class="btn btn-primary btn-full">Place Bid</button>
            </div>
          </div>

          <!-- Auction Card 3 -->
          <div class="auction-card">
            <div class="auction-image">
              <span class="badge">New</span>
              <img src="https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?w=400&h=300&fit=crop" alt="Sneakers">
            </div>
            <div class="auction-details">
              <h3>Limited Edition Nike Air Max</h3>
              <div class="bid-info">
                <div>
                  <span class="label">Current Bid</span>
                  <span class="price">$650</span>
                </div>
                <div>
                  <span class="label">Time Left</span>
                  <span class="time">1d 8h</span>
                </div>
              </div>
              <div class="bid-count">8 bids</div>
              <button class="btn btn-primary btn-full">Place Bid</button>
            </div>
          </div>

          <!-- Auction Card 4 -->
          <div class="auction-card">
            <div class="auction-image">
              <span class="badge live">Live</span>
              <img src="https://images.unsplash.com/photo-1551024601-bec78aea704b?w=400&h=300&fit=crop" alt="Antique Vase">
            </div>
            <div class="auction-details">
              <h3>Antique Chinese Porcelain Vase</h3>
              <div class="bid-info">
                <div>
                  <span class="label">Current Bid</span>
                  <span class="price">$3,100</span>
                </div>
                <div>
                  <span class="label">Time Left</span>
                  <span class="time">45m</span>
                </div>
              </div>
              <div class="bid-count">31 bids</div>
              <button class="btn btn-primary btn-full">Place Bid</button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Categories -->
    <section class="categories">
      <div class="container">
        <h2>Browse Categories</h2>
        <div class="category-grid">
          @forelse($categories as $category)
            <a href="{{ route('frontend.categories.show', $category->id) }}" class="category-card">
              @if(!empty($category->category_image))
                <span class="category-icon">
                  <img src="{{ asset('storage/' . $category->category_image) }}" style="width: 100%; height: 100%; object-fit: cover;" alt="{{ $category->category_name }}">
                </span>
              @else
                <span class="category-icon">{{ substr($category->category_name, 0, 1) }}</span>
              @endif
              <span>{{ $category->category_name }}</span>
            </a>
          @empty
            <p>No categories found.</p>
          @endforelse
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
      <div class="container footer-content">
        <div class="footer-brand">
          <a href="#" class="logo">BidNow</a>
          <p>Your trusted online auction platform since 2020.</p>
        </div>
        <div class="footer-links">
          <div class="footer-column">
            <h4>Company</h4>
            <a href="#">About Us</a>
            <a href="#">Careers</a>
            <a href="#">Press</a>
          </div>
          <div class="footer-column">
            <h4>Support</h4>
            <a href="#">Help Center</a>
            <a href="#">Contact</a>
            <a href="#">FAQs</a>
          </div>
          <div class="footer-column">
            <h4>Legal</h4>
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Service</a>
            <a href="#">Cookie Policy</a>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <div class="container">
          <p>&copy; 2026 BidNow. All rights reserved.</p>
        </div>
      </div>
    </footer>
  </body>
</html>