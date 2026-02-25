<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Order #{{ $order->order_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #e2136e;
            padding-bottom: 20px;
        }

        .logo {
            margin-bottom: 15px;
        }

        .order-info {
            margin-bottom: 30px;
        }

        .info-section {
            margin-bottom: 25px;
        }

        .info-title {
            font-weight: bold;
            color: #333;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .totals {
            float: right;
            width: 300px;
            margin-top: 20px;
        }

        .total-row {
            border-top: 2px solid #000;
            font-weight: bold;
        }

        .currency {
            font-weight: bold;
        }

        /* Bkash Payment Styles */
        .payment-section {
            background: #fef9fc;
            border: 2px solid #e2136e;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
        }

        .bkash-header {
            color: #e2136e;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .payment-details {
            background: white;
            padding: 10px;
            border-radius: 4px;
            margin-top: 10px;
        }

        .payment-detail-row {
            margin-bottom: 8px;
        }

        .payment-detail-label {
            font-weight: bold;
            display: inline-block;
            width: 140px;
        }

        .transaction-id {
            font-family: 'Courier New', monospace;
            background: #f0f0f0;
            padding: 2px 5px;
            border-radius: 3px;
            font-weight: bold;
        }

        .payment-status {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-paid {
            background: #d4edda;
            color: #155724;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-failed {
            background: #f8d7da;
            color: #721c24;
        }

        /* Layout helpers */
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }

        .float-left {
            float: left;
            width: 48%;
        }

        .float-right {
            float: right;
            width: 48%;
        }

        /* Footer */
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('frontend/images/new-leaars-logo.jpg'))) }}"
                style="width:150px;height:80px;">
        </div>
        <h2 style="margin-top: 15px; color: #333;">Order Invoice</h2>
        <p style="margin: 5px 0;">Order #{{ $order->order_number }}</p>
        <p style="margin: 5px 0;">Date: {{ $order->created_at->format('d M Y') }}</p>
    </div>

    <div class="order-info clearfix">
        <div class="float-left">
            <div class="info-section">
                <h3 class="info-title">Order Information</h3>
                <p><strong>Order Date:</strong> {{ $order->created_at->format('d M Y h:i A') }}</p>
                <p><strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}</p>
                <p><strong>Payment Status:</strong>
                    <span class="payment-status status-{{ $order->payment_status }}">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </p>
                <p><strong>Order Status:</strong> {{ ucfirst($order->order_status) }}</p>
            </div>
        </div>

        <div class="float-right">
            <div class="info-section">
                <h3 class="info-title">Customer Information</h3>
                <p><strong>Name:</strong> {{ $order->name }}</p>
                <p><strong>Email:</strong> {{ $order->email }}</p>
                <p><strong>Phone:</strong> {{ $order->phone }}</p>
                <p><strong>Address:</strong> {{ $order->address }}</p>
                <p><strong>City:</strong> {{ $order->city }}</p>
            </div>
        </div>
    </div>

    <!-- Bkash Payment Information (Only show for Bkash payments) -->
    @if($order->payment_method === 'bkash')
        <div class="payment-section">
            <div class="bkash-header">
                📱 Bkash Payment Information
            </div>
            <div class="payment-details">
                <div class="payment-detail-row">
                    <span class="payment-detail-label">Customer Mobile:</span>
                    <span>{{ $order->payment_number ?? 'N/A' }}</span>
                </div>
                <div class="payment-detail-row">
                    <span class="payment-detail-label">Transaction ID:</span>
                    <span class="transaction-id">{{ $order->transaction_number ?? 'N/A' }}</span>
                </div>
                <div class="payment-detail-row">
                    <span class="payment-detail-label">Payment Amount:</span>
                    <span class="currency">৳{{ number_format((float) $order->total, 2, '.', ',') }}</span>
                </div>
                <div class="payment-detail-row">
                    <span class="payment-detail-label">Payment Date:</span>
                    <span>{{ $order->created_at->format('d M Y, h:i A') }}</span>
                </div>
                @if($order->payment_status === 'paid')
                    <div class="payment-detail-row">
                        <span class="payment-detail-label">Status:</span>
                        <span style="color: #28a745; font-weight: bold;"> Payment Verified</span>
                    </div>
                @elseif($order->payment_status === 'pending')
                    <div class="payment-detail-row">
                        <span class="payment-detail-label">Status:</span>
                        <span style="color: #ffc107; font-weight: bold;"> Payment Pending Verification</span>
                    </div>
                @else
                    <div class="payment-detail-row">
                        <span class="payment-detail-label">Status:</span>
                        <span style="color: #dc3545; font-weight: bold;"> Payment Failed/Rejected</span>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <div style="clear: both;"></div>

    <!-- Order Items Table -->
    <div class="info-section">
        <h3 class="info-title">Order Items</h3>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Size</th>
                    <th>Price (৳)</th>
                    <th>Quantity</th>
                    <th>Subtotal (৳)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product->product_name }}</td>

                        <td>{{ $item->variant_size ?? 'N/A' }}</td>
                        <td class="currency">{{ number_format((float) $item->price, 2, '.', ',') }}</td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td class="currency">{{ number_format((float) $item->subtotal, 2, '.', ',') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Order Totals -->
    <div class="totals">
        <table>
            <tr>
                <td><strong>Subtotal:</strong></td>
                <td class="currency">৳{{ number_format((float) $order->subtotal, 2, '.', ',') }}</td>
            </tr>
            <tr>
                <td><strong>Shipping Charge:</strong></td>
                <td class="currency">৳{{ number_format((float) $order->shipping_charge, 2, '.', ',') }}</td>
            </tr>
            <tr>
                <td><strong>Tax:</strong></td>
                <td class="currency">৳{{ number_format((float) $order->tax, 2, '.', ',') }}</td>
            </tr>
            <tr class="total-row">
                <td><strong>Total Amount:</strong></td>
                <td class="currency"><strong>৳{{ number_format((float) $order->total, 2, '.', ',') }}</strong></td>
            </tr>
        </table>
    </div>

    <div style="clear: both;"></div>

    @if($order->order_notes)
        <div class="info-section">
            <h3 class="info-title">Order Notes</h3>
            <p style="background: #f8f9fa; padding: 10px; border-radius: 4px;">{{ $order->order_notes }}</p>
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p><strong>Thank you for your order!</strong></p>
        <p>This is a computer-generated invoice. No signature is required.</p>
        <p>For any queries, please contact us at: support@yourstore.com | +880-XXXXXXXXX</p>
        <p style="margin-top: 10px; font-size: 10px;">Generated on: {{ now()->format('d M Y h:i A') }}</p>
    </div>
</body>

</html>