@php
$banner = App\Models\SpecialBanner::where('status', true)->first();
@endphp

@if($banner)
<section class="special_banner py-4 py-lg-5" style="background-color:antiquewhite;">
    <div class="container">
        <div class="row align-items-center gy-4">
            <!-- Text Content - Order changes on mobile -->
            <div class="col-lg-5 col-12 order-2 order-lg-1">
                <div class="text p-3 p-lg-4">
                    <h3 class="mb-3 mb-lg-4 fs-2">{{ $banner->title }}</h3>
                    <p id="btext" class="mb-0 text-muted">{{ $banner->description }}</p>
                </div>
            </div>

            <!-- Image - Order changes on mobile -->
            <div class="col-lg-7 col-12 order-1 order-lg-2">
                <div class="banner-image-wrapper px-3 px-lg-4">
                    <img src="{{ asset('storage/public/special-banner/' . $banner->image) }}" class="img-fluid rounded shadow-sm w-100" style="object-fit: cover; height: 300px; height: min(400px, 50vh);" alt="{{ $banner->title }}">
                </div>
            </div>
        </div>
    </div>
</section>
@push('ecomcss')
    

<style>
    /* Custom styles for better responsiveness */
    .special_banner {
        overflow: hidden;
    }

    .banner-image-wrapper {
        position: relative;
    }

    .banner-image-wrapper img {
        transition: transform 0.3s ease;
    }

    /* Hover effect only on larger screens */
    @media (min-width: 992px) {
        .banner-image-wrapper img:hover {
            transform: scale(1.02);
        }
    }

    /* Small devices (landscape phones, 576px and up) */
    @media (min-width: 576px) {
        .special_banner h3 {
            font-size: 15px;
        }
    }

    /* Medium devices (tablets, 768px and up) */
    @media (min-width: 768px) {
        .special_banner h3 {
            font-size: 15px;
        }
        #btext{
            font size:12px;
            font-family: 'poppins' sans-serif;
        }
    }

    /* Large devices (desktops, 992px and up) */
    @media (min-width: 992px) {
        .special_banner h3 {
            font-size: 2.25rem;
        }

        .banner-image-wrapper img {
            height: 400px;
        }
    }

    /* Extra large devices (large desktops, 1200px and up) */
    @media (min-width: 1200px) {
        .special_banner h3 {
            font-size: 2rem;
        }
    }

    /* Dark mode support */
    @media (prefers-color-scheme: dark) {
        .special_banner {
            background-color: #f8f4ef !important;
        }
    }

</style>
@endpush
@endif
