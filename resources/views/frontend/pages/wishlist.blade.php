@extends('frontend.master.master')

@section('keyTitle', 'My Wishlist')

@section('contents')
    <div class="container py-5">
        <h2 class="mb-4" style="font-family: var(--font-heading);">My Wishlist</h2>

        @if($products->count() > 0)
            <div class="row">
                @foreach($products as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4">
                        <div class="wishlist-card-wrapper">
                            <x-product-card :product="$product" />
                            <button class="wishlist-remove-btn" onclick="removeFromWishlistPage({{ $product->id }}, this)"
                                title="Remove from wishlist">
                                <i class="fas fa-times"></i> Remove
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="wishlist-empty text-center py-5">
                <i class="fa-regular fa-heart" style="font-size: 64px; color: #ccc; margin-bottom: 20px;"></i>
                <h4 class="text-muted mb-3">Your wishlist is empty</h4>
                <p class="text-muted mb-4">Explore our products and add your favorites here!</p>
                <a href="{{ route('home') }}" class="btn"
                    style="background: var(--primary-color); color: #fff; padding: 10px 30px; font-family: var(--font-heading);">
                    Continue Shopping
                </a>
            </div>
        @endif
    </div>

    @push('ecomcss')
        <style>
            .wishlist-card-wrapper {
                position: relative;
            }

            .wishlist-remove-btn {
                display: block;
                width: 100%;
                margin-top: 6px;
                padding: 8px;
                border: 1px solid #e74c3c;
                background: transparent;
                color: #e74c3c;
                border-radius: 6px;
                font-size: 13px;
                cursor: pointer;
                transition: all 0.2s;
                font-family: var(--font-heading);
            }

            .wishlist-remove-btn:hover {
                background: #e74c3c;
                color: #fff;
            }
        </style>
    @endpush

    @push('ecomjs')
        <script>
            function removeFromWishlistPage(productId, btn) {
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Removing...';

                fetch('/wishlist/toggle', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ product_id: productId }),
                })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            // Animate card out
                            const wrapper = btn.closest('.col-lg-3, .col-md-4, .col-sm-6, .col-6');
                            wrapper.style.transition = 'all 0.3s ease';
                            wrapper.style.opacity = '0';
                            wrapper.style.transform = 'scale(0.95)';
                            setTimeout(() => {
                                wrapper.remove();
                                // Update count badges
                                document.querySelectorAll('.wishlist-count').forEach(el => {
                                    el.textContent = data.count;
                                });
                                // If no items left, reload to show empty state
                                if (data.count === 0) location.reload();
                            }, 300);
                        }
                    });
            }
        </script>
    @endpush
@endsection