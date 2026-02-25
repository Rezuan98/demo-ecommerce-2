@extends('back-end.master')

@section('admin-title')
    Order Details #{{ $order->order_number }}
@endsection

@push('admin-styles')
    <style>
        .card {
            border-radius: 0;
            margin-bottom: 1rem;
        }

        .info-title {
            font-weight: 600;
            color: #6c757d;
            font-size: 14px;
        }

        .info-value {
            font-size: 14px;
        }

        .table th {
            background: #f8f9fa;
            font-weight: 600;
        }

        .badge {
            padding: 6px 12px;
        }

        .status-badge {
            font-size: 14px;
            padding: 8px 15px;
        }

        /* Bkash Payment Styles */
        .bkash-payment-info {
            background: #fef9fc;
            border: 2px solid #e2136e;
            border-radius: 10px;
            padding: 1.5rem;
            margin-top: 1rem;
        }

        .bkash-payment-info code {
            font-family: 'Courier New', monospace;
            font-weight: bold;
            color: #e2136e;
            font-size: 0.9rem;
            background: #fff;
            padding: 4px 8px;
            border-radius: 4px;
            border: 1px solid #e2136e;
        }

        .payment-method-badge {
            font-size: 0.9rem;
            padding: 8px 15px;
            border-radius: 6px;
        }

        .bkash-badge {
            background: #e2136e;
            color: white;
        }

        .cod-badge {
            background: #28a745;
            color: white;
        }

        .alert-sm {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
        }

        .btn-group .btn {
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
        }

        .copy-btn {
            background: #e2136e;
            border: none;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 0.75rem;
            cursor: pointer;
        }

        .copy-btn:hover {
            background: #c01157;
        }

        .payment-verification-section {
            border-top: 2px solid #e2136e;
            margin-top: 1rem;
            padding-top: 1rem;
        }
    </style>
@endpush

@section('admin-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Order Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('order.index') }}">Orders</a></li>
                        <li class="breadcrumb-item active">Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <!-- Action Buttons -->
        <div class="row mb-3">
            <div class="col-12 text-right">
                <a href="{{ route('order.download-pdf', $order->id) }}" class="btn btn-primary">
                    <i class="fas fa-download"></i> Download PDF
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Order Information -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Order Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-5 info-title">Order Number:</div>
                            <div class="col-7 info-value">{{ $order->order_number }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 info-title">Order Date:</div>
                            <div class="col-7 info-value">{{ $order->created_at->format('d M Y h:i A') }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 info-title">Order Status:</div>
                            <div class="col-7">
                                <select class="form-control status-select" data-id="{{ $order->id }}">
                                    <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>
                                        Processing</option>
                                    <option value="shipped" {{ $order->order_status === 'shipped' ? 'selected' : '' }}>Shipped
                                    </option>
                                    <option value="delivered" {{ $order->order_status === 'delivered' ? 'selected' : '' }}>
                                        Delivered</option>
                                    <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>
                                        Cancelled</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 info-title">Payment Method:</div>
                            <div class="col-7 info-value">
                                @if($order->payment_method === 'bkash')
                                    <span class="badge bkash-badge">
                                        <i class="fas fa-mobile-alt"></i> BKASH
                                    </span>
                                @else
                                    <span class="badge cod-badge">
                                        <i class="fas fa-money-bill-wave"></i> COD
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 info-title">Payment Status:</div>
                            <div class="col-7">
                                <span
                                    class="badge badge-{{ $order->payment_status === 'paid' ? 'success' : ($order->payment_status === 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Customer Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-4 info-title">Name:</div>
                            <div class="col-8 info-value">{{ $order->name }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 info-title">Email:</div>
                            <div class="col-8 info-value">{{ $order->email }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 info-title">Phone:</div>
                            <div class="col-8 info-value">{{ $order->phone }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 info-title">Address:</div>
                            <div class="col-8 info-value">{{ $order->address }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 info-title">City:</div>
                            <div class="col-8 info-value">{{ $order->city }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bkash Payment Information (Only show for Bkash payments) -->
            @if($order->payment_method === 'bkash')
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-mobile-alt text-danger"></i> Bkash Payment Information
                        </h5>
                        @if($order->payment_status === 'pending')
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-success"
                                    onclick="updatePaymentStatus({{ $order->id }}, 'paid')">
                                    <i class="fas fa-check"></i> Verify Payment
                                </button>
                                <button type="button" class="btn btn-sm btn-danger"
                                    onclick="updatePaymentStatus({{ $order->id }}, 'failed')">
                                    <i class="fas fa-times"></i> Reject Payment
                                </button>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="bkash-payment-info">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="mb-3">
                                        <i class="fas fa-mobile-alt" style="color: #e2136e;"></i>
                                        Payment Details
                                    </h6>

                                    <div class="row mb-2">
                                        <div class="col-5 info-title">Customer Mobile:</div>
                                        <div class="col-7 info-value">
                                            <strong>{{ $order->payment_number ?? 'N/A' }}</strong>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-5 info-title">Transaction ID:</div>
                                        <div class="col-7 info-value">
                                            @if($order->transaction_number)
                                                <code>{{ $order->transaction_number }}</code>
                                                <button type="button" class="copy-btn ml-2"
                                                    onclick="copyToClipboard('{{ $order->transaction_number }}')">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                            @else
                                                N/A
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-5 info-title">Payment Amount:</div>
                                        <div class="col-7 info-value">
                                            <strong>৳{{ number_format($order->total, 2) }}</strong>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-5 info-title">Payment Date:</div>
                                        <div class="col-7 info-value">{{ $order->created_at->format('d M Y, h:i A') }}</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h6 class="mb-3">
                                        <i class="fas fa-info-circle" style="color: #e2136e;"></i>
                                        Payment Status
                                    </h6>

                                    @if($order->payment_status === 'pending')
                                        <div class="alert alert-warning alert-sm">
                                            <i class="fas fa-clock"></i>
                                            <strong>Action Required:</strong> Please verify this Bkash payment manually by checking
                                            your
                                            Bkash account.
                                        </div>
                                    @elseif($order->payment_status === 'paid')
                                        <div class="alert alert-success alert-sm">
                                            <i class="fas fa-check-circle"></i>
                                            <strong>Payment Verified:</strong> This payment has been confirmed and processed.
                                        </div>
                                    @else
                                        <div class="alert alert-danger alert-sm">
                                            <i class="fas fa-times-circle"></i>
                                            <strong>Payment Rejected:</strong> This payment was marked as failed or invalid.
                                        </div>
                                    @endif

                                    @if($order->payment_status === 'pending')
                                        <div class="payment-verification-section">
                                            <h6 class="mb-2">Verification Steps:</h6>
                                            <ol class="mb-0" style="font-size: 0.85rem;">
                                                <li>Check your Bkash merchant account</li>
                                                <li>Verify transaction ID: <code>{{ $order->transaction_number }}</code></li>
                                                <li>Confirm amount: <strong>৳{{ number_format($order->total, 2) }}</strong></li>
                                                <li>Click "Verify Payment" if valid</li>
                                            </ol>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Order Items -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Order Items</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Image</th>
                                    <th>Size</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>{{ $item->product->product_name }}</td>
                                        <td>
                                            <img src="{{ asset('uploads/products/' . $item->product->product_image) }}"
                                                alt="Product" style="width: 50px; height: 50px; object-fit: cover;">
                                        </td>

                                        <td>{{ $item->variant_size ?? 'N/A' }}</td>
                                        <td>৳{{ number_format($item->price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>৳{{ number_format($item->subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-right"><strong>Subtotal:</strong></td>
                                    <td>৳{{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right"><strong>Shipping Charge:</strong></td>
                                    <td>৳{{ number_format($order->shipping_charge, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right"><strong>Tax:</strong></td>
                                    <td>৳{{ number_format($order->tax, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right"><strong>Total:</strong></td>
                                    <td><strong>৳{{ number_format($order->total, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            @if($order->order_notes)
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Order Notes</h5>
                    </div>
                    <div class="card-body">
                        {{ $order->order_notes }}
                    </div>
                </div>
            @endif
        </div>
@endsection

    @push('admin-scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function () {
                // Order status update
                $('.status-select').on('change', function () {
                    const orderId = $(this).data('id');
                    const status = $(this).val();

                    $.ajax({
                        url: "{{ route('order.updateStatus') }}",
                        type: 'POST',
                        data: {
                            id: orderId,
                            status: status,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            if (response.success) {
                                toastr.success('Order status updated successfully!');
                            } else {
                                toastr.error('Failed to update status!');
                            }
                        },
                        error: function () {
                            toastr.error('Something went wrong!');
                            $(this).val($(this).data('original-status'));
                        }
                    });
                });
            });

            // Payment status update function
            function updatePaymentStatus(orderId, status) {
                if (!confirm(`Are you sure you want to mark this payment as ${status}?`)) {
                    return;
                }

                $.ajax({
                    url: "{{ route('order.updatePaymentStatus') }}",
                    type: 'POST',
                    data: {
                        id: orderId,
                        payment_status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.message);
                            setTimeout(function () {
                                location.reload(); // Reload to show updated status
                            }, 1500);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function () {
                        toastr.error('Failed to update payment status');
                    }
                });
            }

            // Copy to clipboard function
            function copyToClipboard(text) {
                if (navigator.clipboard && window.isSecureContext) {
                    // Modern approach
                    navigator.clipboard.writeText(text).then(function () {
                        toastr.success('Transaction ID copied to clipboard');
                    }, function (err) {
                        console.error('Could not copy text: ', err);
                        fallbackCopyTextToClipboard(text);
                    });
                } else {
                    // Fallback for older browsers
                    fallbackCopyTextToClipboard(text);
                }
            }

            function fallbackCopyTextToClipboard(text) {
                const textArea = document.createElement("textarea");
                textArea.value = text;

                // Avoid scrolling to bottom
                textArea.style.top = "0";
                textArea.style.left = "0";
                textArea.style.position = "fixed";

                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();

                try {
                    const successful = document.execCommand('copy');
                    if (successful) {
                        toastr.success('Transaction ID copied to clipboard');
                    } else {
                        toastr.error('Failed to copy transaction ID');
                    }
                } catch (err) {
                    toastr.error('Failed to copy transaction ID');
                }

                document.body.removeChild(textArea);
            }
        </script>
    @endpush