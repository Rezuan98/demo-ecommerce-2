<section id="new-arrivals-section" class="new-arrivals-products">
    <div class="container-fluid">

        <div class="section-header-with-arrows">
            <h2 class="arrival-section-title">New Arrival Products</h2>
        </div>

        <div class="product-slider-wrapper">
            <button class="slider-arrow slider-arrow-prev" id="arrivals-prev" aria-label="Previous">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="slider-arrow slider-arrow-next" id="arrivals-next" aria-label="Next">
                <i class="fas fa-chevron-right"></i>
            </button>
            <div class="product-slider-track" id="arrivals-track">
                @foreach($new_arrival as $product)
                    <div class="product-slide">
                        <x-product-card :product="$product" />
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</section>

@push('ecomcss')
    <style>
        .arrival-section-title {
            font-family: var(--font-heading);
            font-weight: 700;
            font-size: 26px;
            color: #666;
        }
    </style>
@endpush
