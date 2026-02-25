@push('ecomcss')
<style>
    .category-slider-section {
        background: #fff;
        padding: 40px 0;
        width: 100%;
        overflow: hidden;
    }

    .category-slider .category-item {
        padding: 15px;
    }

    .category-slider .category-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto;
        border-radius: 50%;
        overflow: hidden;
    }

    .category-slider .category-icon img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .category-slider .category-name {
        font-size: 14px;
        margin: 10px 0 0;
        color: #333;

    }

    .category-slider .category-item a {
        text-decoration: none;
    }

    .category-slider .slick-prev,
    .category-slider .slick-next {
        width: 40px;
        height: 40px;
        background: #fff;
        border-radius: 50%;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 1;
        display: flex !important;
        align-items: center;
        justify-content: center;
    }

    .category-slider .slick-prev {
        left: -20px;
    }

    .category-slider .slick-next {
        right: -20px;
    }

    .category-slider .slick-prev:before {
        content: '\f104';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        color: #333;
        font-size: 20px;
    }

    .category-slider .slick-next:before {
        content: '\f105';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        color: #333;
        font-size: 20px;
    }

    .category-slider .slick-prev:hover,
    .category-slider .slick-next:hover {
        background: #f8f9fa;
    }

    .category-slider .slick-prev:before,
    .category-slider .slick-next:before {
        content: '\f104';
        /* Left arrow */
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        color: #333;
        font-size: 20px;
    }

    .category-slider .slick-next:before {
        content: '\f105';
        /* Right arrow */
    }

    .category-slider .slick-prev,
    .category-slider .slick-next {
        font-size: 0;
        /* This hides the text */
        line-height: 0;
    }

    @media (max-width: 768px) {
        .category-slider {
            margin: 0 -5px;
        }

        .category-slider .category-item {
            padding: 5px;
        }

        /* Use a consistent circular size for the arrows */
        .category-slider .slick-prev,
        .category-slider .slick-next {
            width: 20px !important;
            height: 20px !important;
            left: -10px;
        }

        .category-slider .slick-next {
            right: -10px;
            left: auto;
        }

        .category-slider .slick-prev:before,
        .category-slider .slick-next:before {
            font-size: 14px;
        }

        .category-slider .category-name {
            font-size: 8px;
            margin: 5px 0 0;
            color: #333;
        }
    }

</style>
@endpush

@push('ecomjs')
<script>
    $('.category-slider').slick({
        dots: false
        , arrows: true
        , infinite: true
        , speed: 500
        , slidesToShow: 6
        , slidesToScroll: 1
        , responsive: [{
            breakpoint: 768
            , settings: {
                slidesToShow: 3
                , slidesToScroll: 1
            }
        }]
    });

</script>
@endpush
<!-- Category Slider -->
<section class="category-slider-section py-4">
    <div class="container">
        <h2 class="section-title text-center mb-4">Shop By Category</h2>
        <div class="category-slider">
            @foreach($categoryNames as $category)
            <div class="category-item text-center">
                <a href="{{ route('category.products', $category->id) }}">
                    <div class="category-icon mb-2">
                        <img src="{{ asset('storage/'.$category->icon) }}" alt="{{ $category->name }}">
                    </div>
                    <h6 class="category-name">{{ $category->name }}</h6>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
