@extends('frontend.master.master')
@section('keyTitle', 'Order successfull')

@push('ecomcss')
    <style>
        .success-page {
            background-color: #f8f9fa;
            min-height: 100vh;
            padding: 60px 0;
        }

        .success-icon {
            color: #28a745;
            font-size: 4rem;
            margin-bottom: 1.5rem;
        }

        .success-card {
            background-color: #ffffff;
            border: 1px solid #e9ecef;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
        }

        .success-header {
            background-color: #f1f3f4;
            padding: 2rem;
            border-radius: 12px 12px 0 0;
            border-bottom: 1px solid #e9ecef;
        }

        .success-title {
            color: #495057;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .order-number {
            color: #6c757d;
            background-color: #e9ecef;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 600;
        }

        .details-section {
            background-color: #fafbfc;
            padding: 1.5rem;
        }

        .section-title {
            color: #495057;
            font-weight: 600;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 0.5rem;
        }

        .order-table {
            background-color: #ffffff;
        }

        .order-table thead th {
            background-color: #f8f9fa;
            color: #4f565e;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
        }

        .order-table tbody td {
            color: #585e63;
            border-bottom: 1px solid #e9ecef;
        }

        .order-table tfoot td {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #495057;
        }

        .shipping-info {
            background-color: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }

        .shipping-title {
            color: #495057;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .shipping-text {
            color: #6c757d;
            margin-bottom: 0.5rem;
        }

        .continue-btn {
            background-color: #6c757d;
            border-color: #6c757d;
            color: #ffffff;
            padding: 12px 24px;
            font-weight: 500;
            border-radius: 8px;
        }

        .continue-btn:hover {
            background-color: #495057;
            border-color: #495057;
            color: #ffffff;
        }

        .order-summary {
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: 6px;
            margin-top: 1rem;
        }
    </style>
@endpush

@section('contents')
    <div class="success-page">
        <div class="container">
            <div class="text-center mb-5">
                <i class="fas fa-check-circle success-icon"></i>
                <h1 class="success-title">Order Placed Successfully!</h1>
                <p class="text-muted mb-3">Thank you for your purchase. Your order has been received.</p>
                <span class="order-number">Order #{{ $order->order_number }}</span>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="success-card">
                        <div class="success-header text-center">
                            <h3 class="success-title mb-0">Order Confirmation</h3>
                            <p class="text-muted mb-0">We'll send you a confirmation email shortly</p>
                        </div>

                        <div class="details-section">
                            <h5 class="section-title">Order Items</h5>

                            <div class="table-responsive">
                                <table class="table order-table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Variant</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-end">Price</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->items as $item)
                                            <tr>
                                                <td class="fw-medium">{{ $item->product->product_name }}</td>
                                                <td>
                                                    @if($item->variant_size)
                                                        <span class="badge bg-light text-dark">{{ $item->variant_size }}</span>
                                                    @else
                                                        <span class="text-muted">Standard</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $item->quantity }}</td>
                                                <td class="text-end">৳{{ number_format($item->price, 2) }}</td>
                                                <td class="text-end fw-medium">৳{{ number_format($item->subtotal, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" class="text-end">Subtotal:</td>
                                            <td class="text-end">৳{{ number_format($order->subtotal, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-end">Shipping:</td>
                                            <td class="text-end">৳{{ number_format($order->shipping_charge, 2) }}</td>
                                        </tr>
                                        <tr class="table-active">
                                            <td colspan="4" class="text-end fw-bold">Grand Total:</td>
                                            <td class="text-end fw-bold fs-5">৳{{ number_format($order->total, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="shipping-info">
                                        <h6 class="shipping-title">Shipping Address</h6>
                                        <p class="shipping-text mb-2"><strong>{{ $order->name }}</strong></p>
                                        <p class="shipping-text mb-2">{{ $order->address }}</p>
                                        <p class="shipping-text mb-2">{{ $order->city }}</p>
                                        <p class="shipping-text mb-2">📞 {{ $order->phone }}</p>
                                        <p class="shipping-text mb-0">✉️ {{ $order->email }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="shipping-info">
                                        <h6 class="shipping-title">Order Information</h6>
                                        <p class="shipping-text mb-2"><strong>Payment Method:</strong>
                                            {{ ucfirst($order->payment_method) }}</p>
                                        <p class="shipping-text mb-2"><strong>Order Status:</strong>
                                            <span
                                                class="badge bg-warning text-dark">{{ ucfirst($order->order_status) }}</span>
                                        </p>
                                        <p class="shipping-text mb-2"><strong>Order Date:</strong>
                                            {{ $order->created_at->format('M d, Y') }}</p>
                                        @if($order->order_notes)
                                            <p class="shipping-text mb-0"><strong>Notes:</strong> {{ $order->order_notes }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="order-summary mt-4 p-3 text-center">
                                <p class="text-muted mb-3">Your order will be processed within 1-2 business days. You'll
                                    receive tracking information once your order ships.</p>
                                <div class="d-flex justify-content-center gap-3">
                                    <a href="{{ route('home') }}" class="continue-btn btn">Continue Shopping</a>
                                    @auth
                                        <a href="#" class="btn btn-outline-secondary">View All Orders</a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $purchaseItems = [];
        foreach ($order->items as $item) {
            $purchaseItems[] = [
                'item_id' => $item->product->id,
                'item_name' => $item->product->product_name,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'item_category' => $item->product->category->name ?? 'Uncategorized',
                'item_brand' => $item->product->brand->name ?? 'No Brand',
                'item_variant' => $item->variant_size ?? ''
            ];
        }

        $purchaseData = [
            'event' => 'purchase',
            'ecommerce' => [
                'transaction_id' => $order->order_number,
                'affiliation' => 'revencomm',
                'value' => $order->total,
                'currency' => 'BDT',
                'tax' => 0,
                'shipping' => $order->shipping_charge,
                'items' => $purchaseItems
            ]
        ];
    @endphp

    @push('ecomjs')
        <script>
            window.dataLayer = window.dataLayer || [];
            window.dataLayer.push(@json($purchaseData, JSON_UNESCAPED_UNICODE));
        </script>
    @endpush

@endsection