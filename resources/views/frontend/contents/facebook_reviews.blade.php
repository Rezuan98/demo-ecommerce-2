{{-- Updated frontend/contents/facebook_reviews.blade.php --}}

@push('ecomcss')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css">

<style>
.facebook-reviews { padding: 50px 0; background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%); }
.review-section-header { margin-bottom: 15px; margin-top: 15px; }
.review-section-title { font-family: "Conthic", sans-serif; font-weight: 400; font-size: 30px; text-align: left; margin: 0; padding-bottom: 10px; border-bottom: 1px solid #ccc; width: 100%; }
.reviews-slider { position: relative; padding: 0 20px; margin: 0 -2px; }
.review-slide { padding: 0 2px !important; outline: none; }
.review-card { background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08); border: 1px solid #e4e6ea; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); height: 300px; position: relative; }
.review-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, #4267B2, #42b883); opacity: 0; transition: opacity 0.3s ease; }
.review-card:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,0.12); }
.review-card:hover::before { opacity: 1; }
.facebook-embed { width: 100%; height: 100%; border-radius: 8px; overflow: hidden; }
.facebook-embed iframe { width: 100% !important; height: 300px !important; border: none; border-radius: 8px; }
.reviews-slider .slick-prev, .reviews-slider .slick-next { position: absolute; top: 50%; transform: translateY(-50%); z-index: 100; width: 44px; height: 44px; border: none; border-radius: 50%; background: #2c2c2c; color: white; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(44, 44, 44, 0.3); transition: all 0.3s ease; font-size: 0; }
.reviews-slider .slick-prev:hover, .reviews-slider .slick-next:hover { background: var(--primary-color); transform: translateY(-50%) scale(1.1); box-shadow: 0 6px 20px rgba(66, 103, 178, 0.4); }
.reviews-slider .slick-prev { left: -10px; }
.reviews-slider .slick-next { right: -10px; }
.reviews-slider .slick-prev:before, .reviews-slider .slick-next:before { display: none; }
.reviews-slider .slick-prev::after { content: '\f053'; font-family: 'Font Awesome 5 Free'; font-weight: 900; font-size: 14px; color: white; }
.reviews-slider .slick-next::after { content: '\f054'; font-family: 'Font Awesome 5 Free'; font-weight: 900; font-size: 14px; color: white; }
.reviews-slider .slick-dots { bottom: -40px; display: flex !important; justify-content: center; gap: 12px; list-style: none; padding: 0; margin: 0; }
.reviews-slider .slick-dots li { width: auto; height: auto; margin: 0; }
.reviews-slider .slick-dots li button { width: 12px; height: 12px; border-radius: 50%; background: #bcc0c4; border: none; font-size: 0; padding: 0; transition: all 0.3s ease; cursor: pointer; }
.reviews-slider .slick-dots li button:before { display: none; }
.reviews-slider .slick-dots li.slick-active button { background: #2c2c2c; transform: scale(1.3); }
.view-all-btn { display: inline-flex; align-items: center; gap: 10px; background: #2c2c2c; color: white; padding: 14px 28px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 14px; transition: all 0.3s ease; margin-top: 50px; text-transform: uppercase; letter-spacing: 0.5px; }
.view-all-btn:hover { background: #4267B2; color: white; text-decoration: none; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(66, 103, 178, 0.3); }
.view-all-btn i { font-size: 16px; }
@media (max-width: 1200px) { .reviews-slider { padding: 0 15px; margin: 0 -2px; } .review-slide { padding: 0 2px !important; } }
@media (max-width: 992px) { .facebook-reviews { padding: 40px 0; } .review-section-title { font-size: 24px; } .review-card { height: 280px; } .facebook-embed iframe { height: 280px !important; } .review-slide { padding: 0 2px !important; } .reviews-slider .slick-prev { left: -5px; } .reviews-slider .slick-next { right: -5px; } }
@media (max-width: 768px) { .reviews-slider { padding: 0 10px; margin: 0 -1px; } .review-card { height: 260px; } .facebook-embed iframe { height: 260px !important; } .review-slide { padding: 0 1px !important; } .reviews-slider .slick-prev, .reviews-slider .slick-next { width: 38px; height: 38px; } }
@media (max-width: 576px) { .facebook-reviews { padding: 30px 0; } .review-section-title { font-size: 20px; } .reviews-slider .slick-prev, .reviews-slider .slick-next { display: none !important; } .review-card { height: 250px; } .facebook-embed iframe { height: 250px !important; } .review-slide { padding: 0 1px !important; } .reviews-slider { padding: 0 5px; margin: 0; } .view-all-btn { padding: 12px 20px; font-size: 12px; } }
</style>
@endpush

<section class="facebook-reviews">
    <div class="container-fluid">
        <div class="review-section-header">
            <h2 class="review-section-title">
                                           <img style="height:35px;width:35px;border-radius:25px;border:2px solid #FFFFFF" src="{{ asset('frontend/images/Fb.png') }}" alt="">

                Customer Reviews
            </h2>
        </div>

        @if($reviews->isNotEmpty())
        <div class="reviews-slider">
            @foreach($reviews as $review)
            <div class="review-slide">
                <div class="review-card">
                    <div class="facebook-embed">
                        {!! $review->embed_code !!}
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($reviews->first() && $reviews->first()->all_review_link)
        <div class="text-center">
            <a href="{{ $reviews->first()->all_review_link }}" target="_blank" class="view-all-btn">
                <i class="fab fa-facebook"></i>
                <span>View All Reviews</span>
            </a>
        </div>
        @endif
        @endif
    </div>
</section>

@push('ecomjs')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script>
$(function(){
    $('.reviews-slider').slick({
        infinite: true,
        autoplay: true,
        autoplaySpeed: 3500,
        speed: 500,
        slidesToShow: 4,
        slidesToScroll: 1,
        dots: true,
        arrows: true,
        pauseOnHover: true,
        centerMode: false,
        variableWidth: false,
        responsive: [
            { breakpoint: 1400, settings: { slidesToShow: 4, slidesToScroll: 1 } },
            { breakpoint: 1200, settings: { slidesToShow: 3, slidesToScroll: 1 } },
            { breakpoint: 992, settings: { slidesToShow: 2, slidesToScroll: 1 } },
            { breakpoint: 768, settings: { slidesToShow: 2, slidesToScroll: 1 } },
            { breakpoint: 576, settings: { slidesToShow: 1, slidesToScroll: 1, arrows: false, centerMode: false } }
        ]
    });
});
</script>
@endpush