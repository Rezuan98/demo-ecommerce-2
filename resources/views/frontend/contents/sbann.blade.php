@push('ecomcss')
<style>
    .secondery_banner {
        margin: 40px 0;
    }

    .secondery_banner .banner-wrapper {
        position: relative;
        width: 100%;
       
        /* aspect-ratio: 2/1; */
        /* Forces 2:1 aspect ratio */
        margin-bottom: 20px;
    }

    .secondery_banner img {
        width: 100%;
         height: 300px;
        /* height: 100%; */
        object-fit: fill;
        /* Changed from cover to fill */
        border-radius: 8px;
        transition: transform 0.3s ease;
    }

    .secondery_banner .banner-link {
        display: block;
        height: 100%;
    }

    .secondery_banner .banner-link:hover img {
        transform: scale(1.02);
    }

    /* Mobile devices */
    @media (max-width: 768px) {
        .secondery_banner {
            margin: 20px 0;
        }
        .secondery_banner img{

            height: 200px;
            width: 100%;
          
        }

        .secondery_banner .banner-wrapper {
            /* aspect-ratio: 2/1; */
            /* Maintain same ratio on mobile */
        }
    }

</style>
@endpush
@inject('secondaryBanner', 'App\Models\SeconderyBanner')

@php
$leftBanner = $secondaryBanner::where('position', 0)
->where('status', true)
->first();
$rightBanner = $secondaryBanner::where('position', 1)
->where('status', true)
->first();
@endphp
<div class="secondery_banner">
    <div class="container mb-4">
        <div class="row g-2">
            <!-- Increased gap between banners -->
            @if(isset($leftBanner))
            <div class="col-lg-6">
                <div class="banner-wrapper">
                    @if($leftBanner->link)
                    <a href="{{ $leftBanner->link }}" class="banner-link">
                        @endif
                        <img src="{{ asset('storage/public/secondary-banners/' . $leftBanner->image) }}" alt="{{ $leftBanner->title ?? '' }}" title="{{ $leftBanner->title ?? '' }}">
                        @if($leftBanner->link)
                    </a>
                    @endif
                </div>
            </div>
            @endif

            @if(isset($rightBanner))
            <div class="col-lg-6">
                <div class="banner-wrapper">
                    @if($rightBanner->link)
                    <a href="{{ $rightBanner->link }}" class="banner-link">
                        @endif
                        <img src="{{ asset('storage/public/secondary-banners/' . $rightBanner->image) }}" alt="{{ $rightBanner->title ?? '' }}" title="{{ $rightBanner->title ?? '' }}">
                        @if($rightBanner->link)
                    </a>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
