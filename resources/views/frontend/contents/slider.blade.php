{{-- Shatter Hero Slider --}}
<div class="hero-slider" id="heroSlider">
    <div class="hero-slider__track">
        @forelse($sliders as $key => $slider)
            <div class="hero-slider__slide {{ $key == 0 ? 'hero-slider__slide--active' : '' }}" data-index="{{ $key }}">
                <img src="{{ asset('uploads/sliders/' . $slider->image) }}" alt="{{ $slider->title ?? 'Slide Image' }}"
                    class="hero-slider__img" crossorigin="anonymous">

                @if($slider->title || $slider->subtitle)
                    <div class="hero-slider__content">
                        @if($slider->title)
                            <h2 class="hero-slider__title">{{ $slider->title }}</h2>
                        @endif
                        @if($slider->subtitle)
                            <p class="hero-slider__desc">{{ $slider->subtitle }}</p>
                        @endif
                        @if($slider->link)
                            <a href="{{ $slider->link }}" class="hero-slider__btn">Shop Now</a>
                        @endif
                    </div>
                @endif
            </div>
        @empty
            <div class="hero-slider__slide hero-slider__slide--active">
                <img src="#" alt="Default Slide" class="hero-slider__img">
            </div>
        @endforelse
    </div>

    @if($sliders->count() > 1)
        <button class="hero-slider__arrow hero-slider__arrow--prev" id="heroPrev" aria-label="Previous slide">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
        </button>
        <button class="hero-slider__arrow hero-slider__arrow--next" id="heroNext" aria-label="Next slide">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </button>
    @endif
</div>

@push('ecomcss')
    <style>
        /* ── Hero Slider ── */
        .hero-slider {
            position: relative;
            margin-top: -5px;
            width: 100%;
            overflow: hidden;
        }

        .hero-slider__track {
            position: relative;
            width: 100%;
        }

        .hero-slider__slide {
            position: absolute;
            inset: 0;
            opacity: 0;
            z-index: 1;
        }

        .hero-slider__slide--active {
            opacity: 1;
            z-index: 2;
            position: relative; /* gives track its height */
        }

        .hero-slider__img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Ken Burns subtle zoom on active slide */
        .hero-slider__slide--active .hero-slider__img {
            animation: heroKenBurns 6s ease-in-out forwards;
        }

        @keyframes heroKenBurns {
            from { transform: scale(1); }
            to   { transform: scale(1.05); }
        }

        /* ── Navigation Arrows ── */
        .hero-slider__arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            background: transparent;
            border: 2px solid rgba(255, 255, 255, 0.7);
            color: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            transition: opacity 0.3s ease, background-color 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .hero-slider:hover .hero-slider__arrow { opacity: 1; }
        .hero-slider__arrow:hover { background-color: rgba(255, 255, 255, 0.15); }
        .hero-slider__arrow--prev { left: 16px; }
        .hero-slider__arrow--next { right: 16px; }

        /* ── Content Overlay ── */
        .hero-slider__content {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            z-index: 5;
            padding: 0 40px;
            opacity: 0;
            transform: translateY(15px);
            transition: opacity 0.4s ease, transform 0.4s ease;
            pointer-events: none;
        }

        .hero-slider__content--visible {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        .hero-slider__title {
            font-family: var(--font-heading);
            font-size: clamp(18px, 4vw, 42px);
            font-weight: 700;
            color: #fff;
            margin: 0 0 10px;
            text-shadow: 0 2px 12px rgba(0, 0, 0, 0.45);
            line-height: 1.2;
        }

        .hero-slider__desc {
            font-family: var(--font-body);
            font-size: clamp(13px, 1.5vw, 18px);
            font-weight: 400;
            color: rgba(255, 255, 255, 0.9);
            margin: 0 0 20px;
            max-width: 600px;
            text-shadow: 0 1px 6px rgba(0, 0, 0, 0.4);
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .hero-slider__btn {
            display: inline-block;
            padding: clamp(8px, 1.2vw, 12px) clamp(18px, 3vw, 34px);
            background: var(--primary-color);
            color: #fff;
            font-family: var(--font-body);
            font-size: clamp(11px, 1.2vw, 14px);
            font-weight: 600;
            text-decoration: none;
            border-radius: 50px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .hero-slider__btn:hover {
            transform: translateY(-2px);
            filter: brightness(1.1);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
            color: #fff;
            text-decoration: none;
        }

        /* ── Mobile ── */
        @media (max-width: 768px) {
            .hero-slider__arrow {
                opacity: 1;
                width: 30px;
                height: 30px;
                border-width: 1px;
            }
            .hero-slider__arrow--prev { left: 8px; }
            .hero-slider__arrow--next { right: 8px; }
            .hero-slider__arrow svg { width: 14px; height: 14px; }
            .hero-slider__desc { display: none !important; }
            .hero-slider__content { padding: 0 15px; }
        }
    </style>
@endpush

@push('ecomjs')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sliderEl  = document.getElementById('heroSlider');
            const slides    = document.querySelectorAll('#heroSlider .hero-slider__slide');
            const totalSlides = slides.length;
            if (totalSlides <= 1) return;

            let current         = 0;
            let isTransitioning = false;
            let autoPlayTimer   = null;
            const FADE_MS       = 900; // crossfade duration

            // Show first slide content
            const firstContent = slides[0].querySelector('.hero-slider__content');
            if (firstContent) firstContent.classList.add('hero-slider__content--visible');

            /* ── Crossfade Switcher ──────────────────────────────────────── */
            function goToSlide(index) {
                if (isTransitioning) return;
                isTransitioning = true;

                const newIndex  = (index + totalSlides) % totalSlides;
                const fromSlide = slides[current];
                const toSlide   = slides[newIndex];
                const oldTxt    = fromSlide.querySelector('.hero-slider__content');
                const newTxt    = toSlide.querySelector('.hero-slider__content');

                // Hide outgoing text
                if (oldTxt) oldTxt.classList.remove('hero-slider__content--visible');

                // Place incoming slide: absolute, on top (z-index 3), start invisible
                toSlide.style.cssText = 'position:absolute;inset:0;opacity:0;z-index:3;transition:none;';

                // Force reflow so the starting opacity is recognised
                toSlide.offsetHeight;

                // Cross-dissolve: incoming fades in, outgoing fades out simultaneously
                const easing = 'cubic-bezier(0.4, 0, 0.2, 1)';
                toSlide.style.transition   = `opacity ${FADE_MS}ms ${easing}`;
                fromSlide.style.transition = `opacity ${FADE_MS}ms ${easing}`;
                toSlide.style.opacity   = '1';
                fromSlide.style.opacity = '0';

                setTimeout(function () {
                    // Commit the switch
                    fromSlide.classList.remove('hero-slider__slide--active');
                    fromSlide.style.cssText = '';

                    toSlide.style.cssText = '';
                    toSlide.classList.add('hero-slider__slide--active');

                    current = newIndex;

                    if (newTxt) {
                        setTimeout(function () {
                            newTxt.classList.add('hero-slider__content--visible');
                        }, 80);
                    }

                    isTransitioning = false;
                }, FADE_MS + 30);
            }

            /* ── Auto-play ──────────────────────────────────────────────── */
            function startAuto()   { autoPlayTimer = setInterval(function () { goToSlide(current + 1); }, 5000); }
            function restartAuto() { clearInterval(autoPlayTimer); startAuto(); }

            var prevBtn = document.getElementById('heroPrev');
            var nextBtn = document.getElementById('heroNext');

            if (prevBtn) prevBtn.addEventListener('click', function () { goToSlide(current - 1); restartAuto(); });
            if (nextBtn) nextBtn.addEventListener('click', function () { goToSlide(current + 1); restartAuto(); });

            startAuto();
        });
    </script>
@endpush
