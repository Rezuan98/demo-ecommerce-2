@if(isset($featuredCategories) && $featuredCategories->isNotEmpty())

    @foreach($featuredCategories as $cat)
        @php
            $catProducts = ($featuredCategoryProducts->get($cat->id) ?? collect())->take(20);
        @endphp

        @if($catProducts->isNotEmpty())
            <section class="cat-slider-section">
                <div class="container-fluid">

                    <div class="section-header-with-arrows">
                        <h3 class="cat-slider-title">{{ $cat->name }}</h3>
                        <a href="{{ route('category.products', $cat->id) }}" class="cat-slider-view-all">
                            View All <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>

                    <div class="product-slider-wrapper">
                        <button class="slider-arrow slider-arrow-prev" id="cat-prev-{{ $cat->id }}" aria-label="Previous">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="slider-arrow slider-arrow-next" id="cat-next-{{ $cat->id }}" aria-label="Next">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                        <div class="product-slider-track" id="cat-track-{{ $cat->id }}">
                            @foreach($catProducts as $product)
                                <div class="product-slide">
                                    <x-product-card :product="$product" />
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </section>
        @endif
    @endforeach

@push('ecomcss')
    <style>
        .cat-slider-section {
            margin-top: 10px;
        }

        .cat-slider-title {
            font-family: var(--font-heading);
            font-weight: 700;
            font-size: 26px;
            color: #666;
            margin: 0;
        }

        .cat-slider-view-all {
            font-size: 13px;
            color: var(--primary-color, #4f0808);
            text-decoration: none;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: opacity 0.2s ease;
        }

        .cat-slider-view-all:hover {
            opacity: 0.75;
        }
    </style>
@endpush

@push('ecomjs')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @foreach($featuredCategories as $cat)
                makeProductSlider('cat-track-{{ $cat->id }}', 'cat-prev-{{ $cat->id }}', 'cat-next-{{ $cat->id }}');
            @endforeach
        });
    </script>
@endpush

@endif
