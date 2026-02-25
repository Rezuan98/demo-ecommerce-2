<section id="featured-products-section" class="featured-products">
    <div class="container-fluid mt-2">

        <div class="section-header-with-arrows">
            <h3 class="featured-title">Featured Products</h3>
        </div>

        <div class="product-slider-wrapper">
            <button class="slider-arrow slider-arrow-prev" id="featured-prev" aria-label="Previous">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="slider-arrow slider-arrow-next" id="featured-next" aria-label="Next">
                <i class="fas fa-chevron-right"></i>
            </button>
            <div class="product-slider-track" id="featured-track">
                @foreach ($featured as $product)
                    @if ($product->featured)
                        <div class="product-slide">
                            <x-product-card :product="$product" />
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

    </div>
</section>

@push('ecomcss')
    <style>
        .featured-title {
            font-family: var(--font-heading);
            font-weight: 700;
            font-size: 26px;
            color: #666;
        }
    </style>
@endpush

@push('ecomjs')
    <script>
        // ── Reusable product slider factory ─────────────────────────────
        function makeProductSlider(trackId, prevId, nextId) {
            const track   = document.getElementById(trackId);
            const prevBtn = document.getElementById(prevId);
            const nextBtn = document.getElementById(nextId);
            if (!track || !prevBtn || !nextBtn || !track.children.length) return;

            const GAP = 16; // must match CSS gap (16px)
            let idx = 0;

            function perView() {
                const w = window.innerWidth;
                if (w >= 1200) return 4;
                if (w >= 768)  return 3;
                return 2;
            }

            function go(newIdx) {
                const slides = track.children;
                const maxIdx = Math.max(0, slides.length - perView());
                idx = Math.max(0, Math.min(newIdx, maxIdx));
                const slideW = slides[0].getBoundingClientRect().width;
                track.style.transform = `translateX(-${idx * (slideW + GAP)}px)`;
                prevBtn.disabled = idx === 0;
                nextBtn.disabled = idx >= maxIdx;
            }

            prevBtn.addEventListener('click', () => go(idx - 1));
            nextBtn.addEventListener('click', () => go(idx + 1));

            let resizeTimer;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => go(0), 150);
            });

            go(0);
        }

        document.addEventListener('DOMContentLoaded', function () {
            makeProductSlider('featured-track',  'featured-prev',  'featured-next');
            makeProductSlider('arrivals-track',   'arrivals-prev',  'arrivals-next');
        });
    </script>
@endpush
