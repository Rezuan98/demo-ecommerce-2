
<section class="urgent-delivery-section">
    <div class="container">
        <div class="delivery-content">
            <div class="delivery-text">
                <h2 class="delivery-title">
                    Urgent delivery with<br>
                    <span class="brand-name">Uber Connect</span>
                </h2>
                
                <div class="service-info">
                    <div class="service-tag">Inside Dhaka Only</div>
                    <p class="service-description">
                        You can now get your parcel delivered by "Uber Connect" within 2 hours in and around Dhaka
                    </p>
                </div>
                
                <a href="#featured-products-section" class="order-btn">Order Now</a>
            </div>
            
            <div class="delivery-visual">
                <div class="delivery-image-container">
                    <img src="{{ asset('frontend/images/urgent-delivery.jpg') }}" alt="Tazinic Connect Delivery" class="delivery-image">
                </div>
            </div>
        </div>
    </div>
</section>


@push('ecomcss')
<style>
    .urgent-delivery-section {
        padding: 80px 0;
        background: #fff;
        position: relative;
        overflow: hidden;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .delivery-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
        min-height: 500px;
    }

    .delivery-text {
        padding: 20px 0;
    }

    .delivery-title {
        font-size: 50px;
    
        line-height: 1.2;
        color: #524d4d;
        margin-bottom: 40px;
       font-family:"Conthic", sans-serif; font-weight:300;
    }


   .delivery-title .brand-name {
        font-weight: 600;
        color: #000;
        font-size: 35px;
        font-family:"Conthic", sans-serif; font-weight:400;
    }

    .service-info {
        margin-bottom: 40px;
    }

    .service-tag {
        display: inline-block;
        background: #1D4654;
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
       
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 1px;
         font-family:"AloveraDisplay",sans-serif;font-weight:600;
    }

    .service-description {
        font-size: 18px;
        color: #666;
        line-height: 1.6;
        margin-bottom: 30px;
         font-family:"AloveraDisplay",sans-serif;font-weight:300;
    }

    .order-btn {
        display: inline-block;
        background: transparent;
        color: #333;
        border: 2px solid #333;
        padding: 10px 25px;
        text-decoration: none;
       
        font-size: 22px;
        border-radius: 8px;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-family:"Conthic", sans-serif; font-weight:400;
    }

    .order-btn:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(178, 11, 11, 0.3);
    }

    .delivery-visual {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 400px;
    }

    .delivery-image-container {
        position: relative;
        width: 100%;
        max-width: 450px;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    }

    .delivery-image {
        width: 100%;
        height: auto;
        display: block;
        object-fit: cover;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .urgent-delivery-section {
            padding: 60px 0;
        }

        .delivery-content {
            grid-template-columns: 1fr;
            gap: 40px;
            text-align: center;
        }

        .delivery-title {
            font-size: 2.5rem;
            margin-bottom: 30px;
        }

        .service-description {
            font-size: 16px;
        }

        .delivery-image-container {
            max-width: 350px;
        }
    }

    @media (max-width: 480px) {
        .container {
            padding: 0 15px;
        }

        .delivery-title {
            font-size: 2rem;
        }

        .order-btn {
            padding: 12px 30px;
            font-size: 14px;
        }

        .delivery-image-container {
            max-width: 300px;
        }
    }
</style>
@endpush