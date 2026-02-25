@extends('frontend.master.master')
@section('keyTitle', 'Cart')

@section('contents')
    <div class="container">
        <!-- Cart Header -->
        <div class="cart-page-header mb-4">
            <h4 class="fw-bold cart-num-count">
                Shopping Cart ({{ $cartCount }} {{ Str::plural('item', $cartCount) }})
            </h4>
            <a href="{{ route('home') }}" class="btn btn-outline-primary continue-shopping-btn">
                Continue Shopping
            </a>
        </div>

        <!-- Cart Content -->
        <div class="row g-4">
            <!-- Cart Items -->
            <div class="col-lg-8">
                @if($cartItems->count() > 0)
                    @foreach($cartItems as $item)
                        <div class="cart-item-card mb-3">
                            <!-- Desktop Layout -->
                            <div class="desktop-layout d-none d-md-block">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <img src="{{ asset('uploads/products/' . $item->product->product_image) }}"
                                            alt="{{ $item->product->name }}" class="product-image">
                                    </div>
                                    <div class="col-4">
                                        <h6 class="product-title">{{ $item->product->product_name }}</h6>
                                        <div class="product-variants">
                                            <span class="variant-item">Size:
                                                {{ $item->variant && $item->variant->size ? $item->variant->size->name : 'Not Available' }}</span>
                                        </div>
                                        <div class="item-price">৳{{ number_format($item->price, 2) }}</div>
                                    </div>
                                    <div class="col-3">
                                        <div class="quantity-controls">
                                            <button class="qty-btn decrease"
                                                onclick="updateQuantity('{{ $item->id }}', 'decrease')">-</button>
                                            <input type="number" class="quantity-input" value="{{ $item->quantity }}" min="1"
                                                max="10" data-item-id="{{ $item->id }}" readonly>
                                            <button class="qty-btn increase"
                                                onclick="updateQuantity('{{ $item->id }}', 'increase')">+</button>
                                        </div>
                                    </div>
                                    <div class="col-3 text-end">
                                        <div class="item-total">৳{{ number_format($item->price * $item->quantity, 2) }}</div>
                                        <button class="remove-btn" onclick="removeItem('{{ $item->id }}')">
                                            <i class="fas fa-trash"></i> Remove
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Mobile Layout -->
                            <div class="mobile-layout d-block d-md-none">
                                <div class="mobile-cart-item">
                                    <div class="item-header">
                                        <img src="{{ asset('uploads/products/' . $item->product->product_image) }}"
                                            alt="{{ $item->product->name }}" class="mobile-product-image">
                                        <div class="item-info">
                                            <h6 class="mobile-product-title">{{ $item->product->product_name }}</h6>
                                            <div class="mobile-variants">
                                                <span>{{ $item->variant && $item->variant->size ? $item->variant->size->name : 'N/A' }}</span>
                                            </div>
                                            <div class="mobile-price">৳{{ number_format($item->price, 2) }}</div>
                                        </div>
                                        <button class="mobile-remove-btn" onclick="removeItem('{{ $item->id }}')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>

                                    <div class="item-footer">
                                        <div class="mobile-quantity-controls">
                                            <button class="mobile-qty-btn"
                                                onclick="updateQuantity('{{ $item->id }}', 'decrease')">-</button>
                                            <span class="mobile-quantity">{{ $item->quantity }}</span>
                                            <button class="mobile-qty-btn"
                                                onclick="updateQuantity('{{ $item->id }}', 'increase')">+</button>
                                            <input type="hidden" class="quantity-input" value="{{ $item->quantity }}"
                                                data-item-id="{{ $item->id }}">
                                        </div>
                                        <div class="mobile-item-total">
                                            Total: ৳{{ number_format($item->price * $item->quantity, 2) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Empty Cart Message -->
                    <div class="empty-cart-message">
                        <div class="empty-cart-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <h3>Your cart is empty</h3>
                        <p>Looks like you haven't added any items to your cart yet.</p>
                        <a href="{{ route('home') }}" class="btn btn-primary empty-cart-btn">Continue Shopping</a>
                    </div>
                @endif
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="order-summary-card">
                    <h4 class="summary-title">Order Summary</h4>

                    <div class="summary-details">
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span class="cart-subtotal">৳{{ number_format($cartItems->sum(function ($item) {
        return $item->price * $item->quantity;
    }), 2) }}</span>
                        </div>
                        <hr class="summary-divider">
                        <div class="summary-row total-row">
                            <strong>Total</strong>
                            <strong class="cart-total">৳{{ number_format(
        $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        })
    ) }}</strong>
                        </div>
                    </div>

                    @if($cartItems->count() > 0)
                        <a href="{{ route('shipping') }}" class="checkout-btn">
                            Proceed to Checkout
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('ecomcss')
    <style>
        /* Base Styles */
        .cart-page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            border-radius: 0px;
            gap: 1rem;
            padding: 1rem 0;
            margin-top: 50px;
            background-color: var(--primary-color);
        }

        .cart-num-count {
            margin: 0;
            font-size: 1.25rem;
            padding: 0 50px;
            color: #f5f5f5;
            font-family: "Conthic", sans-serif;
        }

        .continue-shopping-btn {
            border-color: #f5f5f5;
            color: #f5f5f5;
            white-space: nowrap;
            margin-right: 10px;
            font-family: "AloveraDisplay", sans-serif;
        }

        .continue-shopping-btn:hover {
            background-color: #f5f5f5;
            border-color: var(--secondery-color);
            color: var(--primary-color);
        }

        /* Desktop Cart Item */
        .cart-item-card {
            background: white;
            border-radius: 0px;
            box-shadow: 0 2px 3px rgba(0, 0, 0, 0.08);
            padding: 1.5rem;
            transition: all 0.3s ease;
        }

        .cart-item-card:hover {

            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
        }

        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 0px;
        }

        .product-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #333;
            font-family: "AloveraDisplay", sans-serif;
        }

        .product-variants {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            margin-bottom: 0.5rem;
        }

        .variant-item {
            font-size: 0.875rem;
            color: #666;
            font-family: "AloveraDisplay", sans-serif;
        }

        .item-price {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 1rem;
            font-family: "AloveraDisplay", sans-serif;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            max-width: 120px;
        }

        .qty-btn {
            background: #f8f9fa;
            border: none;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #666;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .qty-btn:hover {
            background: #e9ecef;
            color: #333;
        }

        .quantity-input {
            border: none;
            width: 48px;
            height: 36px;
            text-align: center;
            font-weight: 600;
            background: white;
            font-family: "AloveraDisplay", sans-serif;
        }

        .item-total {
            font-size: 1.125rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 0.5rem;
            font-family: "AloveraDisplay", sans-serif;
        }

        .remove-btn {
            background: none;
            border: none;
            color: var(--primary-color);
            font-size: 0.875rem;
            cursor: pointer;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            transition: all 0.2s ease;
            font-family: "AloveraDisplay", sans-serif;
        }

        .remove-btn:hover {
            background: var(--primary-color);
            color: white;
        }

        /* Mobile Cart Item */
        .mobile-layout .mobile-cart-item {
            background: white;
            border-radius: 0px;
            padding: 1rem;
            border: 1px solid #f0f0f0;
        }

        .item-header {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .mobile-product-image {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 0px;
            flex-shrink: 0;
        }

        .item-info {
            flex: 1;
        }

        .mobile-product-title {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #333;
            line-height: 1.3;
            font-family: "AloveraDisplay", sans-serif;
        }

        .mobile-variants {
            font-size: 0.875rem;
            color: #666;
            margin-bottom: 0.5rem;
            font-family: "AloveraDisplay", sans-serif;
        }

        .mobile-price {
            font-size: 1rem;
            font-weight: 600;
            color: #9A0000;
            font-family: "AloveraDisplay", sans-serif;
        }

        .mobile-remove-btn {
            background: none;
            border: none;
            color: #999;
            font-size: 1.25rem;
            width: 32px;
            height: 32px;
            border-radius: 0%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            flex-shrink: 0;
            font-family: "AloveraDisplay", sans-serif;
        }

        .mobile-remove-btn:hover {
            background: #f8f9fa;
            color: #dc3545;
        }

        .item-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid #f0f0f0;
        }

        .mobile-quantity-controls {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: #f8f9fa;
            padding: 0.5rem 1rem;
            border-radius: 0px;
        }

        .mobile-qty-btn {
            background: white;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 0%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #666;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
        }

        .mobile-qty-btn:hover {
            background: var(--primary-color);
            transform: scale(1.05);
        }

        .mobile-quantity {
            font-weight: 600;
            font-size: 1rem;
            min-width: 20px;
            text-align: center;
        }

        .mobile-item-total {
            font-weight: 600;
            color: #333;
            font-size: 1rem;
        }

        /* Order Summary */
        .order-summary-card {
            background: white;
            border-radius: 0px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 1.5rem;
            position: sticky;
            top: 1rem;
        }

        .summary-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #333;
            font-family: "AloveraDisplay", sans-serif;
        }

        .summary-details {
            margin-bottom: 1.5rem;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
            font-size: 1rem;
            font-family: "AloveraDisplay", sans-serif;
        }

        .summary-row:last-child {
            margin-bottom: 0;
        }

        .total-row {
            font-size: 1.125rem;
            color: #333;
            font-family: "AloveraDisplay", sans-serif;
        }

        .summary-divider {
            margin: 1rem 0;
            border-color: #f0f0f0;
        }

        .checkout-btn {
            width: 100%;
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 0px;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            display: block;
            text-align: center;

        }

        .checkout-btn:hover {
            background: var(--background-color);
            color: var(--third-color);


        }

        /* Empty Cart */
        .empty-cart-message {
            text-align: center;
            padding: 3rem 1rem;
            background: white;
            border-radius: 0px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .empty-cart-icon {
            font-size: 4rem;
            color: #ddd;
            margin-bottom: 1.5rem;
        }

        .empty-cart-message h3 {
            color: #666;
            margin-bottom: 1rem;
        }

        .empty-cart-message p {
            color: #888;
            margin-bottom: 2rem;
        }

        .empty-cart-btn {
            background: var(--primary-color);
            border-color: var(--secondery-color);
            padding: 0.75rem 2rem;
            border-radius: 0px;
        }

        .empty-cart-btn:hover {
            background: var(--primary-color);
            border-color: var(--secondery-color);
        }

        /* Mobile Responsive */
        @media (max-width: 767px) {
            .cart-header {
                text-align: center;
                flex-direction: column;
                padding: 0.5rem 0;
            }

            .cart-num-count {
                font-size: 1.125rem;
            }

            .continue-shopping-btn {
                font-size: 0.875rem;
                padding: 0.5rem 1rem;
            }

            .cart-item-card {
                padding: 0;
                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
                border: 1px solid #f0f0f0;
            }

            .order-summary-card {
                position: static;
                margin-top: 1rem;
            }

            .summary-title {
                font-size: 1.125rem;
            }

            .mobile-item-total {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            .container {
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }

            .item-header {
                gap: 0.75rem;
            }

            .mobile-product-image {
                width: 60px;
                height: 60px;
            }

            .mobile-product-title {
                font-size: 0.9rem;
            }

            .mobile-variants,
            .mobile-price {
                font-size: 0.8rem;
            }

            .mobile-quantity-controls {
                gap: 0.75rem;
                padding: 0.4rem 0.8rem;
            }

            .mobile-qty-btn {
                width: 28px;
                height: 28px;
                font-size: 0.875rem;
            }

            .mobile-item-total {
                font-size: 0.85rem;
            }

            .summary-row {
                font-size: 0.9rem;
            }

            .total-row {
                font-size: 1rem;
            }
        }

        /* Loading States */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .cart-item-card.removing {
            opacity: 0;
            transform: translateX(-100%);
            transition: all 0.3s ease;
        }

        .quantity-updating {
            background: #f8f9fa;
            border-radius: 0px;
            transition: all 0.2s ease;
        }
    </style>
@endpush

@push('ecomjs')
    <script>
        async function updateQuantity(itemId, action) {
            try {
                const input = document.querySelector(`input[data-item-id="${itemId}"]`);
                const mobileQuantitySpan = document.querySelector(`.mobile-quantity[data-item-id="${itemId}"]`) ||
                    input.closest('.mobile-cart-item')?.querySelector('.mobile-quantity');

                let newValue = parseInt(input.value);

                if (action === 'increase' && newValue < 10) {
                    newValue++;
                } else if (action === 'decrease' && newValue > 1) {
                    newValue--;
                } else {
                    return;
                }

                const cartItem = input.closest('.cart-item-card');
                cartItem.classList.add('quantity-updating');

                const response = await fetch('/cart/update', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        cart_id: itemId,
                        quantity: newValue
                    })
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();

                if (data.success) {
                    input.value = newValue;
                    if (mobileQuantitySpan) {
                        mobileQuantitySpan.textContent = newValue;
                    }

                    document.querySelectorAll('.cart-count').forEach(el => {
                        el.textContent = data.cartCount;
                    });

                    updateCartTotal();
                }

                cartItem.classList.remove('quantity-updating');

            } catch (error) {
                console.error('Error updating quantity:', error);
                const cartItem = document.querySelector(`input[data-item-id="${itemId}"]`).closest('.cart-item-card');
                cartItem.classList.remove('quantity-updating');
            }
        }

        async function removeItem(itemId) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

            if (!csrfToken) {
                console.error('CSRF token not found');
                return;
            }

            if (!confirm('Are you sure you want to remove this item?')) {
                return;
            }

            try {
                const cartItem = document.querySelector(`input[data-item-id="${itemId}"]`).closest('.cart-item-card');
                cartItem.classList.add('removing');

                const response = await fetch('/cart/remove', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        cart_id: itemId
                    })
                });

                const data = await response.json();

                if (data.success) {
                    setTimeout(() => {
                        cartItem.remove();
                        updateCartTotal();
                        checkEmptyCart();
                    }, 300);

                    document.querySelectorAll('.cart-count').forEach(el => {
                        el.textContent = data.cartCount;
                    });
                } else {
                    cartItem.classList.remove('removing');
                    alert(data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                const cartItem = document.querySelector(`input[data-item-id="${itemId}"]`).closest('.cart-item-card');
                cartItem.classList.remove('removing');
                alert('Failed to remove item');
            }
        }

        function updateCartTotal() {
            const cartItems = document.querySelectorAll('.cart-item-card');
            let subtotal = 0;

            cartItems.forEach(item => {
                const input = item.querySelector('.quantity-input');
                const priceElement = item.querySelector('.item-price, .mobile-price');

                if (input && priceElement) {
                    const basePrice = parseFloat(priceElement.textContent.replace('৳', '').replace(',', ''));
                    const quantity = parseInt(input.value);
                    subtotal += basePrice * quantity;

                    const totalElement = item.querySelector('.item-total, .mobile-item-total');
                    if (totalElement) {
                        if (totalElement.classList.contains('mobile-item-total')) {
                            totalElement.textContent = `Total: ৳${numberFormat(basePrice * quantity)}`;
                        } else {
                            totalElement.textContent = '৳' + numberFormat(basePrice * quantity);
                        }
                    }
                }
            });

            const subtotalElement = document.querySelector('.cart-subtotal');
            const totalElement = document.querySelector('.cart-total');

            if (subtotalElement) {
                subtotalElement.textContent = '৳' + numberFormat(subtotal);
            }
            if (totalElement) {
                totalElement.textContent = '৳' + numberFormat(subtotal);
            }
        }

        function checkEmptyCart() {
            const cartItems = document.querySelectorAll('.cart-item-card');
            const cartContent = document.querySelector('.col-lg-8');

            if (cartItems.length === 0) {
                cartContent.innerHTML = `
                <div class="empty-cart-message">
                    <div class="empty-cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h3>Your cart is empty</h3>
                    <p>Looks like you haven't added any items to your cart yet.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary empty-cart-btn">Continue Shopping</a>
                </div>
            `;
            }
        }

        function numberFormat(number) {
            return number.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.mobile-quantity').forEach((span, index) => {
                const cartItem = span.closest('.mobile-cart-item');
                const input = cartItem.querySelector('.quantity-input');
                if (input) {
                    span.setAttribute('data-item-id', input.getAttribute('data-item-id'));
                }
            });
        });
    </script>
@endpush