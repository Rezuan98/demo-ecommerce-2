{{-- resources/views/frontend/contents/recommended_products.blade.php --}}

@if($recommendedProducts->count() > 0)
    <section class="recommended-products-section py-5">
        <div class="container">
            <div class="recommended-section-header text-center mb-4">
                <h2 class="recommended-section-title">You May Also Like</h2>
                <p class="recommended-section-subtitle text-muted">Discover similar products that might interest you</p>
            </div>

            <div class="row g-3">
                @foreach($recommendedProducts as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <x-product-card :product="$product" />
                    </div>
                @endforeach
            </div>

            {{-- View more button --}}
            <div class="text-center mt-4">
                <a href="{{ route('category.products', $recommendedProducts->first()->category_id ?? 1) }}"
                    class="btn btn-outline-primary">
                    View More Products
                </a>
            </div>
        </div>
    </section>

    @push('ecomcss')
        <style>
            .recommended-products-section {
                background-color: #f8f9fa;
                border-top: 1px solid #e9ecef;
            }

            .recommended-section-header {
                margin-bottom: 15px;
                margin-top: 15px;
            }

            .recommended-section-title {
                font-family: "Conthic", sans-serif;
                font-weight: 400;
                font-size: 30px;
                color: #666;
                text-align: left;
                margin: 0;
                padding-bottom: 10px;
                border-bottom: 1px solid #ccc;
                width: 100%;
            }

            @media (max-width: 576px) {
                .recommended-products-section {
                    padding: 2rem 0;
                }
            }
        </style>
    @endpush
@endif