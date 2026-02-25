<!-- WhatsApp Float Button -->
<div class="whatsapp-float">
    <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', $settings->phone) }}?text=Hello%Chileghuri%2C%20I%20need%20help%20with..." target="_blank" class="whatsapp-btn">
        <i class="fab fa-whatsapp"></i>
    </a>
</div>

<!-- Main Footer Section -->
<footer class="chileghuri-main-footer">
    <div class="container">
        <div class="row">
            <!-- Column 1: Know More -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="chileghuri-footer-column">
                    <h5 class="chileghuri-footer-heading">Know More</h5>
                    <ul class="chileghuri-footer-links">
                       
                        <li><a href="{{ route('returns.exchanges') }}">Refund & Return Policy</a></li>
                        <li><a href="{{ route('terms.conditions') }}">Terms of Service</a></li>
                        <li><a href="{{ route('privacy.policy') }}">Privacy Policy</a></li>
                        <li><a href="/shipping-policy">Shipping Policy</a></li>
                    </ul>
                </div>
            </div>

            <!-- Column 2: Support -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="chileghuri-footer-column">
                    <h5 class="chileghuri-footer-heading">Support</h5>
                    <ul class="chileghuri-footer-links">
                        <li><a href="{{ route('contact.us') }}">Contact Us</a></li>
                        <li><a href="{{ route('about.us') }}">About Us</a></li>
                        
                        <li><a href="{{ route('faq') }}">FAQ</a></li>
                        <li><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                       
                    </ul>
                </div>
            </div>

            <!-- Column 3: Brand & Social -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="chileghuri-footer-column">
                    <div class="chileghuri-footer-brand">
                        <img src="{{ asset('storage/' . $settings->logo) }}" alt="{{ $settings->site_name ?? 'Tazinic' }}" class="chileghuri-footer-logo mb-3">
                        <p class="chileghuri-brand-description">
                            {{ $settings->footer_description?? 'RevEnComm offers premium quality products with exceptional service. 
                            Your trusted partner for authentic shopping experience in Bangladesh.' }}
                        </p>
                    </div>
                    <div class="chileghuri-social-media">
                        <h6 class="chileghuri-social-heading">Follow Us</h6>
                        <div class="chileghuri-social-icons">
                            <a href="{{ $settings->facebook_url }}" class="chileghuri-social-link chileghuri-facebook"><img style="height:40px;width:40px;" src="{{ asset('frontend/images/Fb.png') }}" alt=""></a>
                            <a href="{{ $settings->instagram_url }}" class="chileghuri-social-link chileghuri-instagram"><img style="height:40px;width:40px;" src="{{ asset('frontend/images/IG.png') }}" alt=""></a>
                            <a href="{{ $settings->youtube_url }}" class="chileghuri-social-link chileghuri-tiktok"><img style="height:40px;width:40px;" src="{{ asset('frontend/images/TT.png') }}" alt=""></a>
                            <a href="{{ $settings->facebook_url }}" class="chileghuri-social-link chileghuri-twitter"><img style="height:40px;width:40px;" src="{{ asset('frontend/images/X.png') }}" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Column 4: Payment Methods -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="chileghuri-footer-column">
                    <h5 class="chileghuri-footer-heading">Payment Methods</h5>
                    {{-- <div class="chileghuri-payment-methods">
                        <img src="{{ asset('frontend/images/cod.jpg') }}" alt="Visa" class="chileghuri-payment-icon">
                        <img src="{{ asset('frontend/images/bkash.jpg') }}" alt="bKash" class="chileghuri-payment-icon">
                        <img src="{{ asset('frontend/images/nagad.png') }}" alt="Nagad" class="chileghuri-payment-icon">
                        <img src="{{ asset('frontend/images/dbbl.jpg') }}" alt="DBBL" class="chileghuri-payment-icon">
                        <img src="{{ asset('frontend/images/visa.png') }}" alt="Mastercard" class="chileghuri-payment-icon">
                        <img src="{{ asset('frontend/images/rocket.png') }}" alt="Rocket" class="chileghuri-payment-icon">

                        <a target="_blank" href="https://www.sslcommerz.com/" title="SSLCommerz" alt="SSLCommerz"><img style="width:400px;height:300px;" src="https://securepay.sslcommerz.com/public/image/SSLCommerz-Pay-With-logo-All-Size-04.png" /></a>
                    </div> --}}

                    <div class="chileghuri-payment-methods">
                        <img style="width: 300px;" src="{{ asset('frontend/images/paymen.png') }}" alt="">
</div>

                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Copyright Section -->
<div class="chileghuri-copyright-section">
    <div class="container">
        <div class="text-center">
            <div class="chileghuri-copyright-text">
                Copyright © {{ date('Y') }} {{ $settings->site_name ?? 'RevEnComm' }}, All Rights Reserved
            </div>
        </div>
    </div>
</div>

