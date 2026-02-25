@extends('frontend.master.master')
@section('keyTitle','About Us')
@push('ecomcss')
<style>
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    margin-top: 50px;
    color: white;
}

.card {
    transition: transform 0.3s ease;
    border: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.card:hover {
    transform: translateY(-5px);
}
.container .aboutimg {
    height: 500px;
}

.value-icon {
    width: 80px;
    height: 80px;
    background: rgba(102, 126, 234, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.stats-card {
    background: #f8f9fa;
    padding: 2rem;
    border-radius: 10px;
    text-align: center;
}

.stats-number {
    font-size: 2.5rem;
    font-weight: bold;
    color: #667eea;
}

@media (max-width: 768px) {
    .hero-section {
        padding: 3rem 0;
    }
    
    .stats-number {
        font-size: 2rem;
    }
}
</style>
@endpush

@section('contents')
<!-- Hero Section -->
<section class="hero-section py-5">
    <div class="container py-5">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-4">About chileghuri</h1>
                <p class="lead mb-0">Your trusted partner for quality products and exceptional service. We're committed to bringing you the best shopping experience with carefully curated items and reliable delivery.</p>
            </div>
        </div>
    </div>
</section>

<!-- Our Story Section -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <img src="{{ asset('frontend/images/about.webp') }}" alt="About chileghuri" class="img-fluid aboutimg rounded shadow">
            </div>
            <div class="col-lg-6">
                <h2 class="h1 mb-4">Our Story</h2>
                <p class="lead text-muted mb-4">chileghuri was founded with a simple mission: to provide customers with high-quality products at affordable prices, backed by excellent customer service.</p>
                <p class="mb-4">We believe in building lasting relationships with our customers by offering carefully selected products that meet their needs and exceed their expectations. Every item in our store is chosen with care to ensure quality and value.</p>
                
                <!-- Stats -->
                <div class="row g-3 mt-4">
                    <div class="col-6">
                        <div class="stats-card">
                            <div class="stats-number">5+</div>
                            <p class="mb-0">Years of Service</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stats-card">
                            <div class="stats-number">10k+</div>
                            <p class="mb-0">Happy Customers</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Values Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="h1">Why Choose chileghuri?</h2>
            <p class="lead text-muted">What makes us different</p>
        </div>
        
        <div class="row g-4">
            <!-- Quality -->
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body text-center p-4">
                        <div class="value-icon mb-3">
                            <i class="fas fa-star fa-2x text-primary"></i>
                        </div>
                        <h3 class="h4 mb-3">Quality Products</h3>
                        <p class="text-muted mb-0">We carefully select each product to ensure you receive only the best quality items that meet our high standards.</p>
                    </div>
                </div>
            </div>
            
            <!-- Service -->
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body text-center p-4">
                        <div class="value-icon mb-3">
                            <i class="fas fa-headset fa-2x text-primary"></i>
                        </div>
                        <h3 class="h4 mb-3">Excellent Service</h3>
                        <p class="text-muted mb-0">Our customer service team is always ready to help you with any questions or concerns you may have.</p>
                    </div>
                </div>
            </div>
            
            <!-- Delivery -->
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body text-center p-4">
                        <div class="value-icon mb-3">
                            <i class="fas fa-shipping-fast fa-2x text-primary"></i>
                        </div>
                        <h3 class="h4 mb-3">Fast Delivery</h3>
                        <p class="text-muted mb-0">We ensure quick and reliable delivery so you can enjoy your purchases as soon as possible.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="h1 mb-4">Our Mission</h2>
                <p class="lead text-muted mb-4">To be your go-to destination for quality products, exceptional service, and a seamless shopping experience that brings value to your everyday life.</p>
                <a href="{{ route('home') }}" class="btn btn-primary btn-lg">Start Shopping</a>
            </div>
        </div>
    </div>
</section>

@endsection