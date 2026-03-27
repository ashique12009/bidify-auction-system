@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Page Header -->
    <div class="row mb-5">
        <div class="col-md-12 text-center">
            <h1 class="display-4 fw-bold mb-3">How Bidify Works</h1>
            <p class="lead text-muted">Learn how to participate in online auctions and get the best deals</p>
        </div>
    </div>
    
    <!-- Steps Section -->
    <div class="row mb-5">
        <div class="col-md-12">
            <h2 class="text-center mb-4">Getting Started is Easy</h2>
            
            <!-- Step 1 -->
            <div class="row align-items-center mb-5">
                <div class="col-md-6">
                    <div class="text-center mb-4 mb-md-0">
                        <div class="step-number">1</div>
                        <h3>Create Account</h3>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Sign Up for Free</h5>
                            <p class="card-text">
                                Create your account in seconds. All you need is a valid email address to get started. 
                                Once registered, you can immediately start browsing auctions or listing your own items.
                            </p>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>Free registration</li>
                                <li><i class="fas fa-check text-success me-2"></i>Secure account protection</li>
                                <li><i class="fas fa-check text-success me-2"></i>Instant access to all features</li>
                            </ul>
                            <a href="{{ route('register') }}" class="btn btn-primary">Create Account</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Step 2 -->
            <div class="row align-items-center mb-5 flex-row-reverse">
                <div class="col-md-6">
                    <div class="text-center mb-4 mb-md-0">
                        <div class="step-number">2</div>
                        <h3>Browse Auctions</h3>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Find What You Love</h5>
                            <p class="card-text">
                                Explore thousands of active auctions across multiple categories. Use our advanced search 
                                and filters to find exactly what you're looking for.
                            </p>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>Search by keywords</li>
                                <li><i class="fas fa-check text-success me-2"></i>Filter by category and price</li>
                                <li><i class="fas fa-check text-success me-2"></i>Sort by relevance or ending soon</li>
                            </ul>
                            <a href="{{ route('auctions.index') }}" class="btn btn-outline-primary">Browse Auctions</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Step 3 -->
            <div class="row align-items-center mb-5">
                <div class="col-md-6">
                    <div class="text-center mb-4 mb-md-0">
                        <div class="step-number">3</div>
                        <h3>Place Your Bid</h3>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Join the Action</h5>
                            <p class="card-text">
                                Found something you like? Place your bid and compete with other bidders. 
                                You'll receive notifications if you're outbid.
                            </p>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>Real-time bidding</li>
                                <li><i class="fas fa-check text-success me-2"></i>Outbid notifications</li>
                                <li><i class="fas fa-check text-success me-2"></i>Bid history tracking</li>
                            </ul>
                            <a href="{{ route('auctions.index') }}" class="btn btn-outline-primary">Start Bidding</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Step 4 -->
            <div class="row align-items-center mb-5 flex-row-reverse">
                <div class="col-md-6">
                    <div class="text-center mb-4 mb-md-0">
                        <div class="step-number">4</div>
                        <h3>Win & Pay</h3>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Claim Your Prize</h5>
                            <p class="card-text">
                                If you're the highest bidder when the auction ends, you win! Complete the payment 
                                and arrange delivery with the seller.
                            </p>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>Secure payment processing</li>
                                <li><i class="fas fa-check text-success me-2"></i>Buyer protection</li>
                                <li><i class="fas fa-check text-success me-2"></i>Easy communication with sellers</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- For Sellers Section -->
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card bg-light">
                <div class="card-body text-center">
                    <h2 class="mb-4">Want to Sell Items?</h2>
                    <p class="lead mb-4">
                        Join our community of sellers and reach thousands of potential buyers. 
                        List your items and let the bidding begin!
                    </p>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="feature-box">
                                <i class="fas fa-camera fa-3x text-primary mb-3"></i>
                                <h5>Easy Listing</h5>
                                <p class="text-muted">Upload photos and describe your item in minutes</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="feature-box">
                                <i class="fas fa-users fa-3x text-primary mb-3"></i>
                                <h5>Wide Reach</h5>
                                <p class="text-muted">Connect with buyers from all over the world</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="feature-box">
                                <i class="fas fa-shield-alt fa-3x text-primary mb-3"></i>
                                <h5>Safe Transactions</h5>
                                <p class="text-muted">Secure payment system and seller protection</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        @auth
                            @if(auth()->user()->role === 'publisher')
                                <a href="{{ route('products.create') }}" class="btn btn-primary btn-lg">List Your First Item</a>
                            @else
                                <p class="text-muted">Contact us to upgrade your account to publisher status</p>
                            @endif
                        @else
                            <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-2">Register as Seller</a>
                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">Login</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- FAQ Section -->
    <div class="row mb-5">
        <div class="col-md-12">
            <h2 class="text-center mb-4">Frequently Asked Questions</h2>
            
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            Is bidding on Bidify free?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Yes! Browsing auctions and placing bids is completely free for buyers. You only pay if you win an auction.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                            How do I know if I've won an auction?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            You'll receive an email notification and see a "Winner" badge on the auction page. You can also check your dashboard for all your auction activity.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                            What if I'm outbid?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            You'll receive an email notification when someone outbids you. You can then place a higher bid if you're still interested in the item.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                            Is my payment information secure?
                        </button>
                    </h2>
                    <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Absolutely! We use industry-standard encryption and secure payment processors to protect your financial information. Your payment details are never stored on our servers.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                            Can I cancel my bid?
                        </button>
                    </h2>
                    <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Once placed, bids cannot be cancelled. Please bid carefully and only bid on items you're genuinely interested in purchasing.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- CTA Section -->
    <div class="row">
        <div class="col-md-12">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h2 class="mb-3">Ready to Start Bidding?</h2>
                    <p class="lead mb-4">Join thousands of users getting great deals on Bidify</p>
                    <div>
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg me-2">Get Started Now</a>
                        <a href="{{ route('auctions.index') }}" class="btn btn-outline-light btn-lg">Browse Auctions</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.step-number {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    font-weight: bold;
    margin: 0 auto 1rem;
}

.feature-box {
    padding: 2rem 1rem;
}

.feature-box i {
    margin-bottom: 1rem;
}

.flex-row-reverse {
    flex-direction: row-reverse;
}

@media (max-width: 768px) {
    .flex-row-reverse {
        flex-direction: column;
    }
}
</style>
@endsection
