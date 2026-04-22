@extends('layouts.frontend-layout')

@section('content')
<div class="container py-4">
  <div class="row mb-4">
    <div class="col-md-12">
      <h1>Active Auctions</h1>
      <p class="text-muted">Browse and bid on our current auctions</p>
    </div>
  </div>
    
  <div class="row">
    <!-- Auction Grid -->
    <div class="col-md-12">
      <div class="row" id="auctions-grid">
        <!-- Auction Cards -->
        @forelse($auctions ?? [] as $auction)
          <div class="col-md-4 mb-4">
            <div class="card h-100">
              <div class="auction-image">
                <img src="{{ $auction->product_image ? asset('storage/' . $auction->product_image) : asset('images/default-auction.jpg') }}" 
                  alt="{{ $auction->product_name }}" class="card-img-top">
                <span class="badge bg-{{ $auction->status == 'running' ? 'danger' : 'warning' }} position-absolute top-0 start-0 m-2">
                  {{ ucfirst($auction->computed_status) }}
                </span>
              </div>
              <div class="card-body">
                <h5 class="card-title h-60">{{ $auction->product_name }}</h5>
                <p class="card-text text-muted small">{{ Str::limit($auction->description, 100) }}</p>
                
                <div class="bid-info mb-3">
                  <div class="d-flex justify-content-between">
                    <span class="text-muted small">Current Bid:</span>
                    <span class="fw-bold text-primary">${{ number_format($auction->current_price, 2) }}</span>
                  </div>
                  <div class="d-flex justify-content-between">
                    <span class="text-muted small">Bids:</span>
                    <span class="fw-bold">{{ $auction->bids->count() }}</span>
                  </div>
                </div>
                
                <div class="d-grid gap-2">
                  <a href="{{ route('auctions.show', $auction) }}" class="btn btn-primary btn-sm">View Details</a>
                </div>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12">
            <div class="text-center py-5">
              <h3>No Active Auctions</h3>
              <p class="text-muted">Check back later for new auctions</p>
            </div>
          </div>
        @endforelse
      </div>
    </div>
  </div>
</div>
@endsection