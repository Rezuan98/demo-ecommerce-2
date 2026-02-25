@extends('frontend.master.master')

@section('keyTitle', 'Track Your Order')
@push('ecomcss')
    <link rel="stylesheet" href="{{ asset('frontend/css/track_order.css') }}">
@endpush

@section('contents')
    <div class="container track-order-container">
        <div class="track-order-header">
            <h1 class="track-order-title">Track Your Order</h1>
            <p class="track-order-subtitle">Enter your order ID to see the latest status</p>
        </div>

        {{-- Search Form --}}
        <div class="track-search-wrapper">
            <form action="{{ route('track.order') }}" method="GET" class="track-search-form">
                <div class="track-input-group">
                    <i class="fas fa-search track-search-icon"></i>
                    <input type="text" name="order_id" class="track-search-input"
                        placeholder="Enter Order ID (e.g. ORD250223...)" value="{{ request('order_id') }}" required>
                    <button type="submit" class="track-search-btn">Track</button>
                </div>
            </form>
        </div>

        @if($searched && !$order)
            {{-- Order Not Found --}}
            <div class="track-not-found">
                <i class="fas fa-exclamation-triangle"></i>
                <h3>Order Not Found</h3>
                <p>We couldn't find an order with that ID. Please check and try again.</p>
            </div>
        @endif

        @if($order)
            {{-- Order Summary Card --}}
            <div class="track-order-card">
                <div class="track-order-summary">
                    <div class="track-summary-item">
                        <span class="track-label">Order ID</span>
                        <span class="track-value">{{ $order->order_number }}</span>
                    </div>
                    <div class="track-summary-item">
                        <span class="track-label">Order Date</span>
                        <span class="track-value">{{ $order->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="track-summary-item">
                        <span class="track-label">Total</span>
                        <span class="track-value track-price">Tk{{ number_format($order->total, 2) }}</span>
                    </div>
                    <div class="track-summary-item">
                        <span class="track-label">Payment</span>
                        <span class="track-value">
                            <span class="track-badge track-badge-{{ $order->payment_status }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </span>
                    </div>
                </div>
            </div>

            {{-- Tracking Timeline --}}
            <div class="track-timeline-card">
                <h5 class="track-timeline-title">Order Status</h5>
                <div class="track-timeline">
                    @foreach($trackingSteps as $index => $step)
                        <div
                            class="track-step {{ $step['completed'] ? 'completed' : '' }} {{ $step['active'] ? 'active' : '' }} {{ $step['cancelled'] ?? false ? 'cancelled' : '' }}">
                            <div class="track-step-indicator">
                                <div class="track-step-circle">
                                    <i class="fas {{ $step['icon'] }}"></i>
                                </div>
                                @if(!$loop->last)
                                    <div class="track-step-line"></div>
                                @endif
                            </div>
                            <div class="track-step-content">
                                <h6 class="track-step-label">{{ $step['label'] }}</h6>
                                <p class="track-step-desc">{{ $step['description'] }}</p>
                                @if($step['completed'] || $step['active'])
                                    <span class="track-step-date">
                                        <i class="far fa-clock"></i> {{ $step['date'] }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Order Items --}}
            <div class="track-items-card">
                <h5 class="track-items-title">Order Items</h5>
                @foreach($order->items as $item)
                    <div class="track-item">
                        <img src="{{ asset('uploads/products/' . ($item->product->product_image ?? 'default.png')) }}"
                            alt="{{ $item->product->product_name ?? 'Product' }}" class="track-item-img">
                        <div class="track-item-info">
                            <h6 class="track-item-name">{{ $item->product->product_name ?? 'Product' }}</h6>
                            <span class="track-item-variant">
                                Size: {{ $item->variant_size ?? 'N/A' }} &bull; Qty: {{ $item->quantity }}
                            </span>
                        </div>
                        <div class="track-item-price">
                            Tk{{ number_format($item->price * $item->quantity, 2) }}
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if(!$searched)
            {{-- Default State Illustration --}}
            <div class="track-default-state">
                <i class="fas fa-shipping-fast"></i>
                <p>Enter your order ID above to track your order</p>
            </div>
        @endif
    </div>
@endsection