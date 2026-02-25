{{-- <div id="quickview-menu" class="quickview-menu">

    <div class="quickview-menu-content">
        <div class="quickview-header">
            <h6>Quick View</h6>
            <button class="close-btn" onclick="closeQuickViewMenu('quickview-menu')">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>

        <div class="quickview-body" >
            <div class="row g-4">
                <!-- Product Images -->
                <div class="col-lg-6">
                    <div class="product-images">
                        <div class="main-image">
                            <img src="{{ asset('frontend/images/kalindi5.webp') }}" alt="Product">
                        </div>
                        <div class="image-dots">
                            <span class="dot active" data-image="{{ asset('frontend/images/products/p1.webp') }}"></span>
                            <span class="dot" data-image="{{ asset('frontend/images/products/p2.webp') }}"></span>
                            <span class="dot" data-image="{{ asset('frontend/images/products/p3.webp') }}"></span>
                        </div>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="col-lg-6">
                    <div class="product-info">
                        <h4 class="product-menu-title">Product Name Goes Here</h4>
                        <div class="product-price">
                            <span class="current-price">৳1,590</span>
                            <span class="original-price">৳1,990</span>
                        </div>
                        <div class="short-description">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit vitae quaerat iusto autem eius, aspernatur eligendi, ab animi unde tempora laborum dolorem eum veritatis dicta reiciendis ex facilis fugiat! Mollitia tempora consectetur explicabo ullam cupiditate numquam asperiores exercitationem commodi soluta cum, aut possimus ducimus expedita recusandae delectus, ipsa </p>
                        </div>
                        <!-- Size Selection -->
                        <div class="size-selection mt-4">
                            <h6>Size</h6>
                            <div class="size-options">
                                <button class="size-btn">S</button>
                                <button class="size-btn">M</button>
                                <button class="size-btn">L</button>
                                <button class="size-btn">XL</button>
                            </div>
                        </div>

                        <!-- Add to Cart Section -->
                        <div class="cart-actions mt-4">
                            <div class="quantity-wrapper">
                                <button class="qty-btn minus">-</button>
                                <input type="number" value="1" class="qty-input">
                                <button class="qty-btn plus">+</button>
                            </div>

                        </div>
                        <button class="add-to-cart-btn p-3">Add to Cart</button>
                        <button style="border-radius:5px;" class="buy-now-btn p-3 m-2">Buy Now</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@push('ecomcss')

<style>
    .quickview-menu {
    position: fixed;
    top: 0;
    right: -100%; /* Hide completely off-screen */
    width: 50%; /* Adjust width as per design */
    height: 100%;
    background-color: #fff;
    box-shadow: -2px 0 5px rgba(0, 0, 0, 0.3);
    z-index: 1000;
    overflow-y: auto;
    transition: right 0.5s ease; /* Smooth sliding effect */
    padding: 20px;
}
@media (max-width: 768px) {
    .quickview-menu {
        right: -100%; /* Fully hidden for mobile too */
        width: 90%;
    }
}

.quickview-menu.active {
    right: 0; /* Slide into view */
}

.quickview-menu-content {
    height: 100%;
    overflow-y: auto; /* Scroll content if necessary */
}
.quickview-menu, .quickview-menu-content{
    margin: 0;
    padding: 20px;
}

/* Close Button */
.close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 24px;
    background: none;
    border: none;
    cursor: pointer;
    color: #333;
}

/* Button Styles */
.quickview-btn, .plus-btn {
    position: absolute;
    z-index: 999;
    cursor: pointer;
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
   
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

.quickview-btn {
    top: 65px;
    right: 20px;
    width: 35px;
    height: 35px;
}

.plus-btn {
    bottom: 15px;
    right: 15px;
    width: 35px;
    height: 35px;
}



</style>
    
@endpush

@push('ecomjs')
    <script>
        function openQuickViewMenu() {
            
    document.getElementById('quickview-menu').classList.add('active');
}



function closeQuickViewMenu() {
    const menu = document.getElementById('quickview-menu');
    menu.classList.remove('active');
    
}

    </script>
@endpush


 --}}
