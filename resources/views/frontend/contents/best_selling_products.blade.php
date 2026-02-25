@push('ecomcss')
<style>
    .fa-spinner {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

</style>
@endpush

<section id="new-arrivals-section" class="new-arrivals-products">
    <div class="container mt-4">
        <h2 class="section-title" style="text-align: center;">Best Selling Products</h2>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
    @foreach($best_selling as $product)
    @if($product->order_items_count>=1)
    <?php
        $discount_type = $product->discount_type;
        $discount_amount = $product->discount_amount ?? 0;
        $sale_price = $product->sale_price;

        // Default to sale_price if no valid discount
        $final_price = $sale_price;

        if ($discount_amount > 0) {
            if ($discount_type === 'fixed') {
                $final_price = $sale_price - $discount_amount;
            } elseif ($discount_type === 'percentage') {
                $final_price = $sale_price - ($sale_price / 100) * $discount_amount;
            }
        }
    ?>

    <div class="col-md-2-4 col-lg-2-4">
        <div class="new-arrival-box">
            <div class="new-arrival-image">
                <a href="{{ route('product.details',$product->id) }}">
                    <img class="primary-image" src="{{ asset('uploads/products/' . $product->product_image) }}" alt="{{ $product->name }}">
                    @if($product->galleryImages->isNotEmpty())
                    <img class="hover-image" src="{{ asset('uploads/gallery/' . $product->galleryImages->first()->image) }}" alt="{{ $product->name }}">
                    @endif
                </a>
                <button onclick="addToCartFromBestSelling(
                    event,
                    {{ $product->id }},
                    {{ $product->variants->first()->id }},
                    {{ $final_price }},
                    '{{ addslashes($product->product_name) }}',
                    '{{ addslashes($product->brand->name ?? 'No Brand') }}',
                    '{{ addslashes($product->category->name ?? 'Uncategorized') }}',
                    '{{ addslashes($product->product_code) }}'
                )" class="plus-btn" title="Add to Cart">
                    <i class="fas fa-plus"></i>
                </button>
            </div>

            <div class="bsp-product-info">
                <div class="bsp-product-price">
                    <p class="bsp-product-title">
                        {{ $product->product_name }}
                    </p>
                    
                    {{-- Only show discount pricing if there's actually a discount --}}
                    @if($discount_amount > 0 && $final_price < $sale_price)
                    <div class="bsp-price-row d-flex">
                        <span class="bsp-current-price">৳{{ $final_price ?? '00' }}</span>
                        <span class="original-product-price">৳{{ $product->sale_price ?? '00' }}</span>
                    </div>
                    @else
                    <span class="bsp-current-price">৳{{ $sale_price ?? '00' }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach
</div>
            </div>
        </div>
    </div>
</section>

@push('ecomjs')
<script>
    async function addToCartFromBestSelling(event, productId, variantId, price, productName, brandName, categoryName, productCode) {
        try {
            const clickedButton = event.currentTarget;
            clickedButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            clickedButton.disabled = true;

            const response = await fetch('/add-to-cart', {
                method: 'POST'
                , headers: {
                    'Content-Type': 'application/json'
                    , 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    , 'Accept': 'application/json'
                }
                , body: JSON.stringify({
                    product_id: productId
                    , varient_id: variantId
                    , quantity: 1
                    , price: price
                })
            });

            const data = await response.json();

            if (data.success) {
                const cartCountElements = document.querySelectorAll('.cart-count');
                cartCountElements.forEach(element => {
                    element.textContent = data.cartCount;
                });

                toggleCart();

                // ✅ Fire add_to_cart to dataLayer
                window.dataLayer = window.dataLayer || [];
                window.dataLayer.push({
                    event: 'add_to_cart'
                    , ecommerce: {
                        currency: 'BDT'
                        , value: price
                        , items: [{
                            item_id: productId
                            , item_name: productName
                            , price: price
                            , quantity: 1
                            , item_category: categoryName
                            , item_brand: brandName
                            , item_variant: productCode
                        }]
                    }
                });
            }
        } catch (error) {
            console.error('Add to cart failed:', error);
        } finally {
            // Reset button state
            const clickedButton = event.currentTarget;
            clickedButton.innerHTML = '<i class="fas fa-plus"></i>';
            clickedButton.disabled = false;
        }
    }

</script>
@endpush
