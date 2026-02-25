@props(['product'])

@php
    $discount_type = $product->discount_type;
    $discount_amount = $product->discount_amount ?? 0;
    $sale_price = $product->sale_price;
    $final_price = $sale_price;

    // Flat discount overrides individual product discount when active
    if (isset($flatDiscount) && $flatDiscount && $flatDiscount->flat_discount_active && $flatDiscount->flat_discount_amount > 0) {
        $discount_type   = $flatDiscount->flat_discount_type;
        $discount_amount = $flatDiscount->flat_discount_amount;
        if ($discount_type === 'fixed') {
            $final_price = $sale_price - $discount_amount;
        } else {
            $final_price = $sale_price - ($sale_price / 100) * $discount_amount;
        }
    } elseif ($discount_amount > 0) {
        if ($discount_type === 'fixed') {
            $final_price = $sale_price - $discount_amount;
        } elseif ($discount_type === 'percentage') {
            $final_price = $sale_price - ($sale_price / 100) * $discount_amount;
        }
    }
    $final_price = max(0, $final_price);

    $stock = $product->variants_sum_stock_quantity
        ?? $product->total_stock
        ?? $product->variants->sum('stock_quantity');
@endphp

<div class="pc-box">
    {{-- Image container --}}
    <div class="pc-image">
        <a href="{{ route('product.details', $product->id) }}">
            <img class="pc-primary" src="{{ asset('uploads/products/' . $product->product_image) }}"
                alt="{{ $product->product_name }}">

            @if($product->galleryImages->isNotEmpty())
                <img class="pc-hover" src="{{ asset('uploads/gallery/' . $product->galleryImages->first()->image) }}"
                    alt="{{ $product->product_name }}">
            @endif
        </a>

        {{-- Out of stock band --}}
        @if($stock == 0)
            <div class="pc-oos-band">Out of Stock</div>
        @endif

        {{-- Wishlist heart icon --}}
        @php
            $isWishlisted = auth()->check() && auth()->user()->wish->contains($product->id);
        @endphp
        <button class="pc-wishlist-btn {{ $isWishlisted ? 'active' : '' }}" data-wishlist-product="{{ $product->id }}"
            onclick="toggleWishlist({{ $product->id }}, this, event)"
            title="{{ $isWishlisted ? 'Remove from Wishlist' : 'Add to Wishlist' }}">
            <img src="{{ asset('frontend/images/like.png') }}" alt="Wishlist"
                class="pc-wishlist-icon {{ $isWishlisted ? 'wishlisted' : '' }}">
        </button>
    </div>

    {{-- Product info --}}
    <div class="pc-info">
        <a href="{{ route('product.details', $product->id) }}" class="pc-title">
            {{ $product->product_name }}
        </a>

        <div class="pc-price-row">
            <div class="pc-price-left">
                <span class="pc-current-price">
                    Tk{{ number_format(($discount_amount > 0 && $final_price < $sale_price) ? $final_price : $sale_price, 0) }}
                </span>
                <span class="pc-stock">({{ $stock }} Instock)</span>
            </div>

            @if($discount_amount > 0 && $final_price < $sale_price)
                <span class="pc-original-price">Tk{{ number_format($sale_price, 0) }}</span>
            @endif
        </div>
    </div>
</div>