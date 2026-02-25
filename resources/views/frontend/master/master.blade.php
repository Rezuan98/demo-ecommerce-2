<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        // Initialize data layer before GTM
        window.dataLayer = window.dataLayer || [];

        // Push basic data
        dataLayer.push({
            'event': 'pageview'
            , 'siteType': 'e-commerce'
            , 'pageType': '{{ $pageType ?? "other" }}'
            , 'userType': '{{ Auth::check() ? "registered" : "guest" }}'
            , @if(Auth::check())
                'userId': '{{ Auth::id() }}'
            , @endif'currency': 'BDT'

        });

    </script>
    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || []; w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            }); var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', '{{ $gtmData->gtm_code ?? 'GTM-TFXR2C7T' }}');</script>
    <!-- End Google Tag Manager -->



    <title>@yield('keyTitle')</title>
    @if(isset($settings) && $settings->favicon)
        <link rel="icon" sizes="64x86" type="image/png" href="{{ asset('storage/' . $settings->favicon) }}">
    @endif


    @stack('metascinan')
    <meta name="user-authenticated" content="{{ auth()->check() ? '1' : '0' }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/featured.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/new-arrival.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/product-card.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/best_selling.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/cart.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/product_details.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/category-slider2.css') }}">
    {{-- bootstrap css start --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    {{-- bootstrap css end --}}

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600&family=Faculty+Glyphic&family=Inter:ital,opsz,wght@0,14..32,100..900&family=Jost:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
        rel="stylesheet">

    {{-- cdn for slick slider start --}}
    {{--
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" /> --}}


    {{-- cdn for slick slider start --}}
    {{--
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" /> --}}

    @stack('ecomcss')


</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TFXR2C7T" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    @include('frontend.includes.navbar')
    {{-- @include('frontend.includes.second_navbar') --}}
    <section id="main-area">
        @yield('contents')
    </section>
    {{-- @include('frontend.components.loader') --}}
    @include('frontend.includes.footer')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- bootstrap js cdn start --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    {{-- bootstrap js cdn end --}}

    {{--
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script> --}}



    @stack('ecomjs')
    <script src="{{ asset('frontend/js/best_selling_products.js') }}"></script>
    {{--
    <script src="{{ asset('frontend/js/navbar.js') }}"></script> --}}
    <script src="{{ asset('frontend/js/cart.js') }}"></script>
    <script src="{{ asset('frontend/js/product_details.js') }}"></script>

    <script>// Show loader
        function showLoader() {
            document.getElementById('ldrsLoader').style.display = 'block';
        }

        // Hide loader
        function hideLoader() {
            document.getElementById('ldrsLoader').style.display = 'none';
        }

        // Auto hide on page load
        window.addEventListener('load', function () {
            hideLoader();
        });</script>

    {{-- //////////////////elevate zoom js start///////////////////////////// --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/elevatezoom/2.2.3/jquery.elevatezoom.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize zoom for first image
            $("#zoom_image").elevateZoom({
                zoomType: "inner"
                , cursor: "crosshair"
                , zoomWindowFadeIn: 500
                , zoomWindowFadeOut: 750
            });

            // Handle thumbnail clicks
            const thumbnails = document.querySelectorAll('.thumbnail-item');
            thumbnails.forEach(thumb => {
                thumb.addEventListener('click', function () {
                    thumbnails.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // Handle carousel slide event
            $('#productCarousel').on('slid.bs.carousel', function (e) {
                // Remove old zoom
                $('.zoomContainer').remove();

                // Get current slide image
                let currentImage = $(e.relatedTarget).find('img');

                // Reinitialize zoom for current image
                currentImage.elevateZoom({
                    zoomType: "inner"
                    , cursor: "crosshair"
                    , zoomWindowFadeIn: 500
                    , zoomWindowFadeOut: 750
                });
            });
        });

        // Cleanup zoom when leaving page
        $(window).on('beforeunload', function () {
            $('.zoomContainer').remove();
        });

        // Remove zoom on mobile devices
        $(window).on('resize', function () {
            if ($(window).width() < 992) {
                $('.zoomContainer').remove();
            }
        });

    </script>

    {{-- //////////////////elevate zoom js end///////////////////////////// --}}




    @include('frontend.includes.auth-modal')
    <script src="{{ asset('frontend/js/wishlist.js') }}"></script>

</body>

</html>