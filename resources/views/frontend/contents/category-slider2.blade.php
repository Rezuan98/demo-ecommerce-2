@push('ecomcss')
    <!-- Font Awesome (for arrow icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Slick CSS first -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css">

    <style>
        html,
        body {
            overflow-x: hidden;
        }

        .catx-section {
            padding: 60px 0 80px;
        }

        .catx-title {
            text-align: center;
            margin-bottom: 50px;
            display: flex;
            align-items: center;
            text-align: center;
            margin: 50px 0;
        }

        /* .catx-title::before, .catx-title::after { content: ""; flex: 1; border-bottom: 1px solid #8c7d7d; } */
        .catx-title h2 {
            font-family: "Faculty Glyphic", serif;
            font-size: 1.2rem;
            font-weight: 700;
            padding: 0 20px;
            color: #f2f2f2;
            letter-spacing: 1px;
            white-space: nowrap;
            border: 1px solid #987777;
            padding: 6px 20px;
            background-color: #1D4654;
        }

        .catx-title p {
            font-size: 16px;
            color: #6c757d;
            max-width: 600px;
            margin: 0 auto;
        }

        .catx-slider {
            position: relative;
            padding: 0;
        }

        .catx-item {
            padding: 0 5px;
            outline: none;
        }

        .catx-card {
            background: #fff;
            border-radius: 0px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, .1);
            transition: transform .3s, box-shadow .3s;
            position: relative;
            cursor: pointer;
        }

        .catx-card:hover {
            box-shadow: 0 16px 40px rgba(0, 0, 0, .18);
        }

        .catx-image {
            width: 100%;
            aspect-ratio: 4 / 4;
            position: relative;
            overflow: visible;
        }

        .catx-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: transform .3s;
        }

        /* .catx-card:hover .catx-image img { transform: scale(1.05); } */
        .catx-namebar {
            position: static;
            left: 0;
            right: 0;
            bottom: 0;
            padding: 12px 16px;
            background: #FFFFFF;
            color: #868080;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .catx-name {
            font-size: 16px;
            font-weight: 700;
            font-family: "AloveraDisplay", sans-serif;
        }

        .catx-count {
            font-size: 13px;
            opacity: .9;
            font-family: "AloveraDisplay", sans-serif;
        }

        /* Fixed arrow button states */
        .catx-slider .slick-prev,
        .catx-slider .slick-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 100;
            width: 46px;
            height: 46px;
            border: none;
            border-radius: 50%;
            background: #7c6e6e;
            color: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 16px rgba(0, 0, 0, .15);
            transition: all 0.3s ease;
        }

        .catx-slider .slick-prev:hover,
        .catx-slider .slick-next:hover,
        .catx-slider .slick-prev:focus-visible,
        .catx-slider .slick-next:focus-visible {
            background: #1D4654;
            color: #f5f5f5;
        }

        .catx-slider .slick-prev:focus:not(:hover),
        .catx-slider .slick-next:focus:not(:hover) {
            background: #7c6e6e;
            /* your default */
            color: #fff;
        }

        .catx-slider .slick-prev {
            left: 0;
        }

        .catx-slider .slick-next {
            right: 0;
        }

        .catx-slider .slick-prev:before,
        .catx-slider .slick-next:before {
            display: none;
        }

        .catx-slider .slick-prev i,
        .catx-slider .slick-next i {
            font-size: 18px;
            line-height: 1;
        }

        /* Hide default dots */
        .catx-slider .slick-dots {
            display: none !important;
        }

        .catx-slider .slick-list {
            overflow: visible;
            /* allow peeking */
            padding: 0 12.5%;
            /* half a card (25% / 2) on both sides */
        }

        .catx-slider .slick-prev {
            /* peek padding (6.5%) + half of a card (25% / 2 = 12.5%) */
            left: calc(6.5% + 9.5%);
            transform: translate(-50%, -50%);
            /* center the button at that x */
        }

        .catx-slider .slick-next {
            /* same logic from the right side */
            right: calc(6.5% + 9.5%);
            transform: translate(50%, -50%);
            /* center the button at that x */
        }

        /* Floating Scrollbar */
        .catx-scrollbar {
            margin: 30px auto 0;
            max-width: 920px;
            width: 100%;
            height: 4px;
            background: #e6e6e6;
            border-radius: 999px;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .catx-thumb {
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 15% !important;
            background: #888f9b;
            border-radius: 999px;
            cursor: grab;
            /* Floating transition - matches slider animation */
            transition: left 0.6s cubic-bezier(0.4, 0, 0.2, 1), transform .3s cubic-bezier(0.4, 0, 0.2, 1), background .2s;
        }

        .catx-thumb:active,
        .catx-thumb.dragging {
            cursor: grabbing;
            /* Remove transition during active drag for immediate response */
            transition: transform .3s cubic-bezier(0.4, 0, 0.2, 1), background .2s;
        }

        .catx-thumb:hover {
            background: #1D4654;
            transform: scaleY(1.2);
        }

        /* GPU hint for buttery slide animation */
        .slick-track {
            will-change: transform;
        }

        @media (max-width: 992px) {
            .catx-name {
                font-size: 16px;
            }
        }

        @media (max-width: 576px) {

            .catx-slider .slick-prev,
            .catx-slider .slick-next {
                width: 40px;
                height: 40px;
            }

            .catx-title h2 {
                padding: 5px;
                font-family: "Faculty Glyphic", serif;
                margin: 0px 0;
                font-size: 12px;
            }

            .catx-slider .slick-prev {
                left: 0;
            }

            .catx-slider .slick-next {
                right: 0;
            }

            .catx-item {
                padding: 0 0px;
                outline: none;
            }

            .catx-scrollbar {
                max-width: 250px;
            }
        }
    </style>
@endpush

<section class="catx-section">
    <div class="container-fluid">
        <header class="slider-section-header v2">
            <h2 class="slider-section-title">Shop By Category</h2>
        </header>

        <div class="catx-slider mt-4">
            @forelse ($sliderCategory ?? [] as $cat)
                @php
                    $rawImg = $cat->icon;
                    if ($rawImg) {
                        $isRemote = str_starts_with($rawImg, 'http://') || str_starts_with($rawImg, 'https://');
                        $imgSrc = $isRemote ? $rawImg : asset('storage/' . $rawImg);
                    } else {
                        $imgSrc = null;
                    }
                @endphp

                <div class="catx-item">
                    <div class="catx-card" data-category-id="{{ $cat->id }}" onclick="redirectToCategory({{ $cat->id }})">
                        <div class="catx-image">
                            @if($imgSrc)
                                <img src="{{ $imgSrc }}" alt="{{ $cat->name }}">
                            @endif
                            <div class="catx-namebar">
                                <div class="catx-name">{{ $cat->name }}</div>
                                @if(isset($cat->products_count))
                                    <div class="catx-count">{{ $cat->products_count }} Products</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">No categories available.</p>
            @endforelse
        </div>

        <!-- Custom Floating Scrollbar -->
        <div class="catx-scrollbar" id="catxScrollbar">
            <div class="catx-thumb" id="catxScrollbarThumb"></div>
        </div>
    </div>
</section>

@push('ecomjs')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script>
        $(function () {
            // Global dragging flag for click-to-category protection
            window.catxDragging = false;

            var $slider = $('.catx-slider');
            var $scrollbar = $('#catxScrollbar');
            var $thumb = $('#catxScrollbarThumb');
            var isAnimating = false;
            var isThumbAnimating = false;

            $slider.slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                infinite: true,
                autoplay: true,
                autoplaySpeed: 3000,
                speed: 600,
                dots: false,
                arrows: true,
                centerMode: false,
                easing: 'ease-in-out',
                // Floating-feel essentials
                waitForAnimate: false,
                cssEase: 'cubic-bezier(0.4,0,0.2,1)',
                useTransform: true,
                appendArrows: '.catx-slider .slick-list',

                prevArrow: '<button type="button" class="slick-prev" aria-label="Previous"><i class="fa-solid fa-chevron-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next" aria-label="Next"><i class="fa-solid fa-chevron-right"></i></button>',
                responsive: [
                    { breakpoint: 992, settings: { slidesToShow: 2 } },
                    { breakpoint: 576, settings: { slidesToShow: 1, arrows: false } }
                ]
            });

            function getState() {
                var slick = $slider.slick('getSlick');
                var total = slick.slideCount;
                var show = slick.options.slidesToShow;
                var curr = slick.currentSlide;
                if (curr < 0) curr = 0;
                var maxIndex = Math.max(0, total - show);
                return { slick, total, show, curr, maxIndex };
            }

            function layoutThumb(animate = true) {
                if (isThumbAnimating) return;

                var { total, show, curr, maxIndex } = getState();
                var trackW = $scrollbar.width();
                var minThumb = 30;
                var thumbW = Math.max(minThumb, trackW * (show / Math.max(1, total)));

                $thumb.width(thumbW);

                var usable = Math.max(1, trackW - thumbW);
                var ratio = (maxIndex === 0) ? 0 : (curr / maxIndex);
                var left = ratio * usable;

                // Floating animation for thumb when not dragging
                if (animate && !window.catxDragging) {
                    $thumb.css({
                        'left': left + 'px',
                        'transition': 'left 0.6s cubic-bezier(0.4,0,0.2,1), transform .3s cubic-bezier(0.4,0,0.2,1), background .2s'
                    });
                } else {
                    $thumb.css('left', left + 'px');
                }
            }

            function goFromThumbLeft(leftPx, smooth = true) {
                if (isAnimating && smooth) return;

                var { maxIndex } = getState();
                var trackW = $scrollbar.width();
                var thumbW = $thumb.outerWidth();
                var usable = Math.max(1, trackW - thumbW);
                var clamped = Math.min(Math.max(0, leftPx), usable);
                var ratio = clamped / usable;
                var target = Math.round(ratio * maxIndex);

                isAnimating = true;
                $slider.slick('slickGoTo', target, false);

                setTimeout(() => {
                    isAnimating = false;
                }, smooth ? 600 : 100);
            }

            // Sync thumb with slider changes
            $slider.on('beforeChange', function () {
                isAnimating = true;
            });

            $slider.on('afterChange', function () {
                setTimeout(() => {
                    layoutThumb(true);
                    isAnimating = false;
                }, 50);
            });

            $slider.on('setPosition breakpoint reInit', function () {
                layoutThumb(false);
            });

            $(window).on('resize', function () {
                layoutThumb(false);
            });

            // Enhanced drag with floating scrollbar animation
            (function enableDrag() {
                var dragging = false, startX = 0, startLeft = 0;
                var dragThreshold = 3;
                var hasMoved = false;
                var lastTarget = -1;
                var updateTimer;

                function pointerDown(clientX) {
                    dragging = true;
                    window.catxDragging = true;
                    isThumbAnimating = true;
                    hasMoved = false;
                    startX = clientX;
                    startLeft = parseFloat($thumb.css('left')) || 0;
                    $thumb.addClass('dragging');
                    $slider.slick('slickPause');

                    // Remove floating transition during drag for immediate response
                    $thumb.css('transition', 'transform .3s cubic-bezier(0.4,0,0.2,1), background .2s');
                }

                function pointerMove(clientX) {
                    if (!dragging) return;

                    var dx = Math.abs(clientX - startX);
                    if (dx > dragThreshold) {
                        hasMoved = true;
                    }

                    if (hasMoved) {
                        var newLeft = startLeft + (clientX - startX);

                        var { maxIndex } = getState();
                        var trackW = $scrollbar.width();
                        var thumbW = $thumb.outerWidth();
                        var usable = Math.max(1, trackW - thumbW);
                        var clamped = Math.min(Math.max(0, newLeft), usable);
                        var ratio = clamped / usable;
                        var target = Math.round(ratio * maxIndex);

                        // Update thumb position immediately
                        $thumb.css('left', clamped + 'px');

                        // Debounced slider update for smooth floating feel
                        if (target !== lastTarget) {
                            lastTarget = target;

                            if (updateTimer) clearTimeout(updateTimer);
                            updateTimer = setTimeout(() => {
                                $slider.slick('slickGoTo', target, false);
                            }, 80);
                        }
                    }
                }

                function pointerUp() {
                    if (!dragging) return;
                    dragging = false;
                    window.catxDragging = false;
                    $thumb.removeClass('dragging');
                    lastTarget = -1;

                    if (updateTimer) {
                        clearTimeout(updateTimer);
                        updateTimer = null;
                    }

                    // Restore floating transition
                    setTimeout(() => {
                        isThumbAnimating = false;
                        $thumb.css('transition', 'left 0.6s cubic-bezier(0.4,0,0.2,1), transform .3s cubic-bezier(0.4,0,0.2,1), background .2s');
                    }, 100);

                    setTimeout(() => {
                        $slider.slick('slickPlay');
                    }, 300);
                }

                // Mouse events
                $thumb.on('mousedown', function (e) {
                    e.preventDefault();
                    pointerDown(e.clientX);
                });

                $(document).on('mousemove', function (e) {
                    pointerMove(e.clientX);
                });

                $(document).on('mouseup', function () {
                    pointerUp();
                });

                // Touch events
                $thumb.on('touchstart', function (e) {
                    var t = e.originalEvent.touches[0];
                    pointerDown(t.clientX);
                });

                $(document).on('touchmove', function (e) {
                    if (window.catxDragging) {
                        e.preventDefault();
                        var t = e.originalEvent.touches[0];
                        pointerMove(t.clientX);
                    }
                }, { passive: false });

                $(document).on('touchend touchcancel', function () {
                    pointerUp();
                });

                // Click on track for smooth jump
                $scrollbar.on('click', function (e) {
                    if (e.target === $thumb[0] || window.catxDragging) return;

                    var rect = this.getBoundingClientRect();
                    var clickX = e.clientX - rect.left;
                    var thumbW = $thumb.outerWidth();

                    $slider.slick('slickPause');
                    goFromThumbLeft(clickX - thumbW / 2, true);

                    setTimeout(() => {
                        $slider.slick('slickPlay');
                    }, 800);
                });
            })();

            // Initial layout
            layoutThumb(false);

            // Category redirect with drag protection
            function redirectToCategory(categoryId) {
                if (categoryId && !window.catxDragging) {
                    window.location.href = "{{ route('category.products', '') }}/" + categoryId;
                }
            }

            window.redirectToCategory = redirectToCategory;
        });
    </script>
@endpush

@push('ecomcss')
    <style>
        ..slider-section-header {
            margin-bottom: 15px;
            margin-top: 15px;
        }

        .slider-section-title {
            font-family: "Conthic", sans-serif;
            font-weight: 400;
            font-size: 30px;
            color: #666;
            font-weight: bold;
            text-align: left;
            margin: 0;
            padding-bottom: 10px;
            border-bottom: 1px solid #ccc;
            width: 100%;
        }
    </style>
@endpush