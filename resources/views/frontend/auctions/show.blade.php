@extends('layouts.frontend-layout')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8">
            <!-- Auction Details -->
            <div class="card">
                <div class="auction-image">
                    <img src="{{ $auction->product_image ? asset('storage/' . $auction->product_image) : asset('images/default-auction.jpg') }}" 
                         alt="{{ $auction->product_name }}" class="img-fluid">
                    <span class="badge bg-{{ $auction->status == 'running' ? 'danger' : 'warning' }} position-absolute top-0 start-0 m-2">
                        {{ ucfirst($auction->status) }}
                    </span>
                </div>
                <div class="card-body">
                    <h1 class="card-title">{{ $auction->product_name }}</h1>
                    <p class="card-text">{{ $auction->description }}</p>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="bid-info">
                                <h6>Auction Details</h6>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Current Bid:</span>
                                    <span class="fw-bold text-primary fs-4">${{ number_format($auction->current_price, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Starting Bid:</span>
                                    <span>${{ number_format($auction->start_price, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Total Bids:</span>
                                    <span class="fw-bold">{{ $auction->bids->count() }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Category:</span>
                                    <span>{{ $auction->category->category_name }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="time-info">
                                <h6>Auction Timeline</h6>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Start Time:</span>
                                    <span>{{ $auction->start_time ? $auction->start_time->format('M d, Y h:i A') : 'Not Started' }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">End Time:</span>
                                    <span>{{ $auction->end_time ? $auction->end_time->format('M d, Y h:i A') : 'Not Set' }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Time Left:</span>
                                    <span class="fw-bold text-danger" id="time-left">Calculating...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @auth
                        @if($auction->status === 'running')
                            <div class="mt-4">
                                <h6>Place Your Bid</h6>
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if(session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <form action="{{ route('bids.place') }}" method="POST" class="bid-form">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $auction->id }}">
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" name="bid_amount" class="form-control" 
                                               step="0.01" min="{{ $auction->current_price + 1 }}" 
                                               value="{{ $auction->current_price + 1 }}" required>
                                        <button type="submit" class="btn btn-primary">Place Bid</button>
                                    </div>
                                    <small class="text-muted">Minimum bid: ${{ number_format($auction->current_price + 1, 2) }}</small>
                                </form>
                            </div>
                        @else
                            <div class="mt-4">
                                <div class="alert alert-info">
                                    <strong>Auction {{ $auction->status }}</strong>
                                    @if($auction->status === 'ended')
                                        <br>This auction has ended.
                                    @else
                                        <br>This auction has not started yet.
                                    @endif
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="mt-4">
                            <div class="alert alert-warning">
                                <strong>Login Required</strong>
                                <br>Please <a href="{{ route('login') }}">login</a> to place a bid.
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Bid History -->
            <div class="card">
                <div class="card-header">
                    <h6>Bid History</h6>
                </div>
                <div class="card-body">
                    @forelse($auction->bids as $bid)
                        <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                            <div>
                                <strong>{{ $bid->user->name }}</strong>
                                <br><small class="text-muted">{{ $bid->created_at->format('M d, h:i A') }}</small>
                            </div>
                            <span class="fw-bold">{{ $bid->bid_amount }}</span>
                        </div>
                    @empty
                        <p class="text-muted text-center">No bids yet</p>
                    @endforelse
                    
                    @if($auction->bids->count() > 5)
                        <div class="text-center mt-3">
                            <button class="btn btn-sm btn-outline-primary" onclick="loadMoreBids()">
                                Load More Bids
                            </button>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Seller Info -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6>Seller Information</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                {{ strtoupper(substr($auction->publisher->name, 0, 1)) }}
                            </div>
                        </div>
                        <div>
                            <strong>{{ $auction->publisher->name }}</strong>
                            <br><small class="text-muted">Member since {{ $auction->publisher->created_at->format('M Y') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($auction->status === 'running' && $auction->end_time)
<script>
// Countdown timer
function updateCountdown() {
    const endTime = new Date('{{ $auction->end_time->toISOString() }}').getTime();
    const now = new Date().getTime();
    const distance = endTime - now;
    
    if (distance < 0) {
        document.getElementById('time-left').innerHTML = "Auction Ended";
        return;
    }
    
    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
    document.getElementById('time-left').innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s";
}

setInterval(updateCountdown, 1000);
updateCountdown();
</script>
@endif
@endsection
