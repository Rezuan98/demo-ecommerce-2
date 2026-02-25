<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Order Notification</title>
    <style>
        :root {
            --primary-color: #1D4654;
            --secondary-color: #000000;
            --third-color: #423F3F;
            --background-color: #FFFFFF;
        }

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
        .order-info h3,
        .section-title,
        .customer-box h3,
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

        .email-container {
            background-color: #FFFFFF;
            max-width: 600px;
            margin: 20px auto;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .content {
            padding: 30px 20px;
        }

        .order-info {
            background-color: #f8f9fa;
            border-left: 4px solid #1D4654;
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 4px;
        }

        .order-info h3 {
            margin: 0 0 10px;
            font-size: 18px;
            color: #1D4654;
        }

        .order-info p {
            margin: 5px 0;
            font-size: 14px;
        }

        .order-info strong {
            color: #333;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin: 25px 0 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #1D4654;
        }

        .customer-box {
            background-color: #e7f3ff;
            border-left: 4px solid #1D4654;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .customer-box h3 {
            margin: 0 0 10px;
            font-size: 16px;
            color: #1D4654;
        }

        .customer-box p {
            margin: 5px 0;
            font-size: 14px;
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .products-table thead {
            background-color: #1D4654;
            color: #ffffff;
        }

        .products-table th {
            padding: 12px 10px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
        }

        .products-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 14px;
        }

        .products-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .variant-info {
            font-size: 12px;
            color: #666;
            margin-top: 3px;
        }

        .totals {
            margin-top: 20px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }

        .totals-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 14px;
        }

        .totals-row.grand-total {
            border-top: 2px solid #1D4654;
            margin-top: 10px;
            padding-top: 15px;
            font-size: 18px;
            font-weight: 700;
            color: #1D4654;
        }

        .payment-info {
            background-color: #d4edda;
            border-left: 4px solid #28a745;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .payment-info p {
            margin: 5px 0;
            font-size: 14px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-paid {
            background-color: #d4edda;
            color: #155724;
        }

        .action-button {
            display: inline-block;
            padding: 12px 30px;
            background: #1D4654;
            color: #ffffff;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            margin: 20px 0;
            text-align: center;
        }

        .action-button:hover {
            opacity: 0.9;
        }

        .notes-box {
            background-color: #fff9e6;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .notes-box h3 {
            margin: 0 0 10px;
            font-size: 16px;
            color: #856404;
        }

        .notes-box p {
            margin: 0;
            font-size: 14px;
            color: #333;
        }

        .footer {
            background-color: #2c3e50;
            color: #ffffff;
            padding: 25px 20px;
            text-align: center;
        }

        .footer p {
            margin: 5px 0;
            font-size: 13px;
        }

        @media only screen and (max-width: 600px) {
            .email-container {
                margin: 0;
                border-radius: 0;
            }

            .content {
                padding: 20px 15px;
            }

            .products-table th,
            .products-table td {
                padding: 8px 5px;
                font-size: 12px;
            }

            .header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>New Order Received!</h1>

        </div>



        <!-- Order Information -->
        <div class="order-info">
            <h3>Order #{{ $order->order_number }}</h3>
            <p><strong>Order Date:</strong> {{ $order->created_at->format('F d, Y h:i A') }}</p>
            <p><strong>Order Status:</strong> <span
                    class="status-badge status-pending">{{ ucfirst($order->order_status) }}</span></p>
            <p><strong>Payment Status:</strong> <span
                    class="status-badge status-{{ $order->payment_status }}">{{ ucfirst($order->payment_status) }}</span>
            </p>
            <p><strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}</p>
        </div>

        <!-- Customer Information -->
        <h3 class="section-title">Customer Details</h3>
        <div class="customer-box">
            <h3>Contact Information</h3>
            <p><strong>Name:</strong> {{ $order->name }}</p>
            <p><strong>Email:</strong> <a href="mailto:{{ $order->email }}">{{ $order->email }}</a></p>
            <p><strong>Phone:</strong> <a href="tel:{{ $order->phone }}">{{ $order->phone }}</a></p>
        </div>

        <div class="customer-box">
            <h3>Shipping Address</h3>
            <p>{{ $order->address }}</p>
            <p>{{ $order->city }}</p>
        </div>

        <!-- Payment Information -->
        @if($order->payment_method === 'bkash' && $order->bkash_transaction_id)
            <h3 class="section-title">Payment Details</h3>
            <div class="payment-info">
                <p><strong>Bkash Transaction ID:</strong> {{ $order->bkash_transaction_id }}</p>
                <p><strong>Bkash Mobile:</strong> {{ $order->bkash_mobile }}</p>
                <p style="margin-top: 10px; color: #856404;"><em>⚠️ Please verify this transaction before processing the
                        order.</em></p>
            </div>
        @endif

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
                <h3>Customer Notes</h3>
                <p>{{ $order->order_notes }}</p>
            </div>
        @endif

        <!-- Action Button -->
        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ url('/admin/orders/' . $order->id . '/details') }}" class="action-button">
                View Order Details
            </a>
        </div>

        <p style="margin-top: 30px; text-align: center; color: #666; font-size: 14px;">
            Please process this order as soon as possible.
        </p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>{{ config('app.name') }} - Admin Panel</strong></p>
        <p style="margin-top: 15px; font-size: 12px; opacity: 0.8;">
            This is an automated notification. Do not reply to this email.
        </p>
    </div>
    </div>
</body>

</html>