<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: 'Alovera Display', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #FFFFFF;
            color: #000000;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        h1,
        h2,
        h3,
        .header h1,
        .order-info h2,
        .section-title,
        .notes-box h3 {
            font-family: 'Conthic', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .header {
            background: #1D4654;
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }

        .header p {
            margin: 10px 0 0;
            font-size: 16px;
            opacity: 0.9;
        }

        .order-info h2 {
            color: #1D4654;
            margin: 0 0 10px;
            font-size: 20px;
        }

        .section-title {
            border-bottom: 2px solid #1D4654;
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin: 25px 0 15px;
            padding-bottom: 10px;
        }

        .products-table thead {
            background-color: #1D4654;
            color: #ffffff;
        }

        .totals-row.grand-total {
            color: #1D4654;
            border-top: 2px solid #1D4654;
            margin-top: 10px;
            padding-top: 15px;
            font-size: 18px;
            font-weight: 700;
        }

        .footer a {
            color: #1D4654;
            text-decoration: none;
        }

        .order-info {
            border-left: 4px solid #1D4654;
            background-color: #f8f9fa;
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 4px;
        }

        .email-container {
            background-color: #FFFFFF;
            max-width: 600px;
            margin: 20px auto;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .content {
            background-color: #FFFFFF;
            padding: 30px 20px;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>Order Confirmed!</h1>
            <p>Thank you for your order</p>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Order Information -->
            <div class="order-info">
                <h2>Order #{{ $order->order_number }}</h2>
                <p><strong>Order Date:</strong> {{ $order->created_at->format('F d, Y h:i A') }}</p>
                <p><strong>Order Status:</strong> <span
                        class="status-badge status-pending">{{ ucfirst($order->order_status) }}</span></p>
                <p><strong>Payment Status:</strong> <span
                        class="status-badge status-{{ $order->payment_status }}">{{ ucfirst($order->payment_status) }}</span>
                </p>
            </div>

            <p>Hi <strong>{{ $order->name }}</strong>,</p>
            <p>We've received your order and will process it shortly. Here are your order details:</p>

            <!-- Shipping Address -->
            <h3 class="section-title">Shipping Address</h3>
            <div class="address-box">
                <p><strong>{{ $order->name }}</strong></p>
                <p>{{ $order->address }}</p>
                <p>{{ $order->city }}</p>
                <p>Phone: {{ $order->phone }}</p>
                <p>Email: {{ $order->email }}</p>
            </div>

            <!-- Payment Information -->
            <h3 class="section-title">Payment Information</h3>
            <div class="payment-info">
                <p><strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}</p>
                <p><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>
                @if($order->bkash_transaction_id)
                    <p><strong>Transaction ID:</strong> {{ $order->bkash_transaction_id }}</p>
                    <p><strong>Bkash Number:</strong> {{ $order->bkash_mobile }}</p>
                @endif
            </div>

            <!-- Order Items -->
            <h3 class="section-title">Order Items</h3>
            <table class="products-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th style="text-align: center;">Qty</th>
                        <th style="text-align: right;">Price</th>
                        <th style="text-align: right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>
                                <strong>{{ $item->product->product_name ?? 'N/A' }}</strong>
                                @if($item->variant_size)
                                    <div class="variant-info">
                                        {{ $item->variant_size }}
                                    </div>
                                @endif
                            </td>
                            <td style="text-align: center;">{{ $item->quantity }}</td>
                            <td style="text-align: right;">৳{{ number_format($item->price, 2) }}</td>
                            <td style="text-align: right;">৳{{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Order Totals -->
            <div class="totals">
                <div class="totals-row">
                    <span>Subtotal:</span>
                    <span>৳{{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="totals-row">
                    <span>Shipping Charge:</span>
                    <span>৳{{ number_format($order->shipping_charge, 2) }}</span>
                </div>
                @if($order->tax > 0)
                    <div class="totals-row">
                        <span>Tax:</span>
                        <span>৳{{ number_format($order->tax, 2) }}</span>
                    </div>
                @endif
                <div class="totals-row grand-total">
                    <span>Grand Total:</span>
                    <span>৳{{ number_format($order->total, 2) }}</span>
                </div>
            </div>

            <!-- Order Notes -->
            @if($order->order_notes)
                <div class="notes-box">
                    <h3>Order Notes</h3>
                    <p>{{ $order->order_notes }}</p>
                </div>
            @endif

            <p style="margin-top: 30px;">If you have any questions about your order, please don't hesitate to contact
                us.</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>{{ config('app.name') }}</strong></p>
            @php
                $siteSetting = \App\Models\SiteSetting::first();
            @endphp
            @if($siteSetting)
                <p>{{ $siteSetting->address }}</p>
                <p>Phone: {{ $siteSetting->phone }} | Email: <a
                        href="mailto:{{ $siteSetting->email }}">{{ $siteSetting->email }}</a></p>
            @endif
            <p style="margin-top: 15px; font-size: 12px; opacity: 0.8;">
                © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </p>
        </div>
    </div>
</body>

</html>