@extends('layouts.frontend-layout')

@section('content')
<div class="container py-4">
  <div class="row g-4">
    <div class="col-md-8">
      <!-- Auction Details -->
      <div class="card">
        <div class="auction-image">
          <img src="{{ $auction->product_image ? asset('storage/' . $auction->product_image) : asset('images/default-auction.jpg') }}" 
            alt="{{ $auction->product_name }}" class="img-fluid">
          <span class="badge bg-{{ $auction->status == 'running' ? 'danger' : 'warning' }} position-absolute top-0 start-0 m-2">
            {{-- {{ ucfirst($auction->status) }} --}}
            {{ ucfirst($auction->computed_status) }}
          </span>
        </div>
          <div class="card-body">
            <h1 class="card-title">{{ $auction->product_name }}</h1>
            <p class="card-text">{{ $auction->description }}</p>
              
            <div class="row mt-4">
              <div class="col-md-12">
                <div class="bid-info">
                  <h6>Auction Details</h6>
                  <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Current Bid:</span>
                    <span class="fw-bold text-primary" id="current_bid">${{ number_format($auction->current_price, 2) }}</span>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Starting Bid:</span>
                    <span>${{ number_format($auction->start_price, 2) }}</span>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Total Bids:</span>
                    <span class="fw-bold" id="total_bids">{{ $auction->bids->count() }}</span>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Category:</span>
                    <span>{{ $auction->category->category_name }}</span>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="time-info">
                  <h6>Auction Timeline</h6>
                  <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Start Time:</span>
                    <span>{{ $auction->start_time ? $auction->start_time->format('M d, Y h:i A') : 'Not set' }}</span>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">End Time:</span>
                    <span>{{ $auction->end_time ? $auction->end_time->format('M d, Y h:i A') : 'Not set' }}</span>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Time Left:</span>
                    <span class="fw-bold text-danger" id="time-left">Calculating...</span>
                  </div>
                </div>
              </div>
            </div>
              
            @auth
              @if($auction->status === 'running' && (!$auction->end_time || !$auction->end_time->isPast()))
                <div class="mt-4">
                  <h6>Place Your Bid</h6>
                  <div id="bid-alert"></div>
                  <form id="bid-form" class="bid-form">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $auction->id }}">
                    <div class="input-group">
                      <span class="input-group-text">$</span>
                      <input type="number" name="bid_amount" class="form-control" 
                        step="0.01" min="{{ $auction->current_price + 1 }}" 
                        value="{{ $auction->current_price + 1 }}" required>
                      <button type="submit" class="btn btn-primary" id="bid-submit-btn">Place Bid</button>
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
                    @elseif($auction->status === 'pending')
                      <br>This auction has not started yet.
                    @else
                      <br>This auction is no longer active.
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
        <div class="card-body" id="bid-history">
          @forelse($auction->bids as $bid)
            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
              <div>
                <strong>{{ $bid->user->name }}</strong>
                <br><small class="text-muted">{{ $bid->created_at->format('M d, h:i A') }}</small>
              </div>
              <span class="fw-bold">${{ number_format($bid->bid_amount, 2) }}</span>
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
            <div class="flex-shrink-0">
              <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                {{ strtoupper(substr($auction->publisher->name, 0, 1)) }}
              </div>
            </div>
            <div class="flex-grow-1 ms-3">
              <h6 class="mb-0">{{ $auction->publisher->name }}</h6>
              <small class="text-muted">Member since {{ $auction->publisher->created_at->format('M Y') }}</small>
            </div>
          </div>
          <div class="mt-3">
            <a href="#" class="btn btn-sm btn-outline-primary">Contact Seller</a>
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
    // Disable bid form when auction ends
    const bidForm = document.querySelector('#bid-form');
    console.log('Auction ended, disabling bid form:', bidForm);
    if (bidForm) {
      const submitBtn = bidForm.querySelector('button[type="submit"]');
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Auction Ended';
      }
    }
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

<script>
// Wait for DOM to be ready
document.addEventListener('DOMContentLoaded', function() {
    // AJAX Bid Submission
    const bidForm = document.getElementById('bid-form');
    if (bidForm) {
        bidForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('bid-submit-btn');
            const originalText = submitBtn.textContent;
            
            // Show loading state
            submitBtn.disabled = true;
            submitBtn.textContent = 'Placing Bid...';
            
            const formData = new FormData(this);
            const productId = formData.get('product_id');
            const bidAmount = formData.get('bid_amount');
            
            axios.post('/bids/place', {
                product_id: productId,
                bid_amount: bidAmount,
                _token: '{{ csrf_token() }}'
            })
            .then(response => {
                if (response.data.success) {
                    // Show success message
                    showBidAlert('success', response.data.message);
                    
                    // Update current bid display
                    const currentBidElement = document.getElementById('current_bid');
                    if (currentBidElement) {
                        currentBidElement.textContent = '$' + parseFloat(bidAmount).toFixed(2);
                    }
                    
                    // Update total bids
                    const totalBidsElement = document.getElementById('total_bids');
                    if (totalBidsElement) {
                        const currentBids = parseInt(totalBidsElement.textContent);
                        totalBidsElement.textContent = currentBids + 1;
                    }
                    
                    // Update minimum bid
                    const minBid = parseFloat(bidAmount) + 1;
                    const bidInput = document.querySelector('input[name="bid_amount"]');
                    if (bidInput) {
                        bidInput.min = minBid;
                        bidInput.value = minBid;
                    }
                    
                    // Update minimum bid text
                    const minBidText = document.querySelector('small.text-muted');
                    if (minBidText) {
                        minBidText.textContent = 'Minimum bid: $' + minBid.toFixed(2);
                    }
                    
                    // Reset button
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }
            })
            .catch(error => {
                console.error('Bid submission error:', error);
                
                // Show error message
                let errorMessage = 'An error occurred while placing your bid.';
                if (error.response && error.response.data.message) {
                    errorMessage = error.response.data.message;
                }
                
                showBidAlert('danger', errorMessage);
                
                // Reset button
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            });
        });
    }
});

// Show bid alerts
function showBidAlert(type, message) {
    const alertDiv = document.getElementById('bid-alert');
    if (!alertDiv) {
        console.error('Alert container not found');
        return;
    }
    
    alertDiv.innerHTML = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>`;
    
    // Auto dismiss after 5 seconds
    setTimeout(() => {
        const alert = alertDiv.querySelector('.alert');
        if (alert) {
            alert.classList.remove('show');
            setTimeout(() => alert.remove(), 150);
        }
    }, 5000);
}

// Laravel Echo Real-time Listening
@if(auth()->check())
    window.addEventListener('load', function() {

        if (window.Echo) {
            console.log('✅ Laravel Echo is available! Setting up real-time channel...');
            window.Echo.channel('auction.{{ $auction->id }}')
                .listen('BidPlaced', (e) => {
                    console.log('🔔 New bid received:', e);
                    
                    // Update current bid
                    const currentBidElement = document.getElementById('current_bid');
                    if (currentBidElement) {
                        currentBidElement.textContent = '$' + parseFloat(e.bid.bid_amount).toFixed(2);
                    }
                    
                    // Update total bids
                    const totalBidsElement = document.getElementById('total_bids');
                    if (totalBidsElement) {
                        const currentBids = parseInt(totalBidsElement.textContent);
                        totalBidsElement.textContent = currentBids + 1;
                    }
                    
                    // Update minimum bid
                    const minBid = parseFloat(e.bid.bid_amount) + 1;
                    const bidInput = document.querySelector('input[name="bid_amount"]');
                    if (bidInput) {
                        bidInput.min = minBid;
                        bidInput.value = minBid;
                    }
                    
                    // Update minimum bid text
                    const minBidText = document.querySelector('small.text-muted');
                    if (minBidText) {
                        minBidText.textContent = 'Minimum bid: $' + minBid.toFixed(2);
                    }
                    
                    // Add new bid to history (at the top)
                    const bidHistory = document.getElementById('bid-history');
                    if (bidHistory) {
                        const newBidHtml = `
                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom" style="background-color: #e8f5e8; padding: 8px; border-radius: 4px; margin-bottom: 8px;">
                                <div>
                                    <strong>${e.bid.user.name}</strong>
                                    <br><small class="text-muted">Just now</small>
                                </div>
                                <span class="fw-bold text-success">$${parseFloat(e.bid.bid_amount).toFixed(2)}</span>
                            </div>
                        `;
                        
                        // Remove "No bids yet" message if it exists
                        const noBidsMessage = bidHistory.querySelector('.text-muted.text-center');
                        if (noBidsMessage) {
                            noBidsMessage.remove();
                        }
                        
                        bidHistory.insertAdjacentHTML('afterbegin', newBidHtml);
                        
                        // Show notification
                        showBidAlert('info', `💰 New bid of $${parseFloat(e.bid.bid_amount).toFixed(2)} placed by ${e.bid.user.name}`);
                    }
                });
        }
        else {
            console.error('❌ Echo is not available!');
        }
        console.log('🎯 Real-time listening started for auction {{ $auction->id }}');
    });
@endif
</script>
@endsection
