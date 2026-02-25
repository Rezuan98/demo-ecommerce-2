@extends('back-end.master')

@section('admin-title')
Manage Orders
@endsection

@push('admin-styles')
<style>
    .card {
        border-radius: 0;
    }
    .table thead tr th {
        background: #f5f5f5;
    }
    .table thead tr th, .table thead tr td {
        font-size: 14px;
    }
    label {
        display: inline-block;
        margin-bottom: .5rem;
        font-size: 14px;
    }
    h4.card-title {
        font-size: 18px!important;
    }
    .badge {
        font-size: 12px;
        padding: 6px 12px;
        border-radius: 4px;
    }
    .bulk-actions {
        display: none;
        background: #f8f9fa;
        padding: 10px;
        border: 1px solid #dee2e6;
        margin-bottom: 20px;
        border-radius: 4px;
    }
    .bulk-actions.show {
        display: block;
    }

    /* Order Status Colors */
    .status-pending {
        background-color: #fff3cd !important;
        border-left: 4px solid #ffc107 !important;
    }
    .status-processing {
        background-color: #d1ecf1 !important;
        border-left: 4px solid #17a2b8 !important;
    }
    .status-shipped {
        background-color: #cce5ff !important;
        border-left: 4px solid #007bff !important;
    }
    .status-delivered {
        background-color: #d4edda !important;
        border-left: 4px solid #28a745 !important;
    }
    .status-cancelled {
        background-color: #f8d7da !important;
        border-left: 4px solid #dc3545 !important;
    }

    /* Status Select Styling */
    .status-select {
        border-radius: 20px !important;
        font-weight: 600;
    }
    .status-select[data-status="pending"] {
        background-color: #fff3cd;
        color: #856404;
        border-color: #ffc107;
    }
    .status-select[data-status="processing"] {
        background-color: #d1ecf1;
        color: #0c5460;
        border-color: #17a2b8;
    }
    .status-select[data-status="shipped"] {
        background-color: #cce5ff;
        color: #004085;
        border-color: #007bff;
    }
    .status-select[data-status="delivered"] {
        background-color: #d4edda;
        color: #155724;
        border-color: #28a745;
    }
    .status-select[data-status="cancelled"] {
        background-color: #f8d7da;
        color: #721c24;
        border-color: #dc3545;
    }

    /* Payment Status Colors */
    .payment-status-select[data-payment="pending"] {
        background-color: #fff3cd;
        color: #856404;
        border-color: #ffc107;
        border-radius: 20px;
        font-weight: 600;
    }
    .payment-status-select[data-payment="paid"] {
        background-color: #d4edda;
        color: #155724;
        border-color: #28a745;
        border-radius: 20px;
        font-weight: 600;
    }
    .payment-status-select[data-payment="failed"] {
        background-color: #f8d7da;
        color: #721c24;
        border-color: #dc3545;
        border-radius: 20px;
        font-weight: 600;
    }

    /* Status Badges */
    .status-badge {
        padding: 6px 12px;
        border-radius: 15px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
    }
    .status-badge.pending {
        background-color: #ffc107;
        color: #856404;
    }
    .status-badge.processing {
        background-color: #17a2b8;
        color: white;
    }
    .status-badge.shipped {
        background-color: #007bff;
        color: white;
    }
    .status-badge.delivered {
        background-color: #28a745;
        color: white;
    }
    .status-badge.cancelled {
        background-color: #dc3545;
        color: white;
    }
    .status-badge.paid {
        background-color: #28a745;
        color: white;
    }
    .status-badge.failed {
        background-color: #dc3545;
        color: white;
    }
</style>
@endpush

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Orders</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Orders</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title">Manage Orders</h4>
        <div class="float-right">
            <!-- Status Legend -->
            <small>
                <span class="status-badge pending">Pending</span>
                <span class="status-badge processing">Processing</span>
                <span class="status-badge shipped">Shipped</span>
                <span class="status-badge delivered">Delivered</span>
                <span class="status-badge cancelled">Cancelled</span>
            </small>
        </div>
    </div>
    <div class="card-body">
        <!-- Bulk Actions Bar -->
        <div id="bulkActions" class="bulk-actions">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <span id="selectedCount">0</span> selected
                </div>
                <div class="col-md-3">
                    <select id="bulkOrderStatus" class="form-control">
                        <option value="">Update Order Status</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="bulkPaymentStatus" class="form-control">
                        <option value="">Update Payment Status</option>
                        <option value="pending">Pending</option>
                        <option value="paid">Paid</option>
                        <option value="failed">Failed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button id="applyBulkChanges" class="btn btn-primary">Apply</button>
                </div>
                <div class="col-md-2">
                    <button id="clearSelection" class="btn btn-secondary">Clear</button>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table id="zero_config" class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="selectAll">
                        </th>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Payment Method</th>
                        <th>Payment Status</th>
                        <th>Order Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $key => $order)
                    <tr class="status-{{ $order->order_status }}">
                        <td>
                            <input type="checkbox" class="order-checkbox" value="{{ $order->id }}">
                        </td>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            {{ $order->name }}<br>
                            <small>{{ $order->phone }}</small>
                        </td>
                        <td>{{ $order->items->count() }}</td>
                        <td>৳{{ number_format($order->total, 2) }}</td>
                        <td>{{ strtoupper($order->payment_method) }}</td>
                        <td>
                            <select class="form-control payment-status-select" 
                                    data-id="{{ $order->id }}" 
                                    data-payment="{{ $order->payment_status }}"
                                    style="width: 140px; margin: auto;">
                                <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-control status-select" 
                                    data-id="{{ $order->id }}" 
                                    data-status="{{ $order->order_status }}"
                                    style="width: 140px; margin: auto;">
                                <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->order_status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->order_status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td>
                            <button title="Action" class="btn without-focus border-0 px-1 py-0 mr-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item" href="{{ route('order.details',$order->id) }}">
                                    <i class="fa fa-eye"></i> View Details
                                </a>
                                <a class="dropdown-item" href="{{ route('order.download-pdf',$order->id) }}">
                                    <i class="fa fa-file-pdf"></i> Invoice
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('admin-scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Update row and select colors on page load
    updateStatusColors();

    // Individual status update
    $('.status-select').on('change', function() {
        const orderId = $(this).data('id');
        const status = $(this).val();
        const row = $(this).closest('tr');
        
        $.ajax({
            url: "{{ route('order.updateStatus') }}",
            type: 'POST',
            data: {
                id: orderId,
                status: status,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if(response.success) {
                    // Update row class
                    row.removeClass('status-pending status-processing status-shipped status-delivered status-cancelled');
                    row.addClass('status-' + status);
                    
                    // Update select data attribute and styling
                    row.find('.status-select').attr('data-status', status);
                    updateStatusColors();
                    
                    toastr.success('Order status updated successfully!');
                } else {
                    toastr.error('Failed to update status!');
                }
            },
            error: function() {
                toastr.error('Something went wrong!');
            }
        });
    });

    $('.payment-status-select').on('change', function() {
        const orderId = $(this).data('id');
        const paymentStatus = $(this).val();
        
        $.ajax({
            url: "{{ route('order.updatePaymentStatus') }}",
            type: 'POST',
            data: {
                id: orderId,
                payment_status: paymentStatus,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if(response.success) {
                    // Update select data attribute and styling
                    $(this).attr('data-payment', paymentStatus);
                    updateStatusColors();
                    
                    toastr.success('Payment status updated successfully!');
                } else {
                    toastr.error('Failed to update payment status!');
                }
            },
            error: function() {
                toastr.error('Something went wrong!');
            }
        });
    });

    function updateStatusColors() {
        // Update status select colors
        $('.status-select').each(function() {
            $(this).attr('data-status', $(this).val());
        });
        
        // Update payment status select colors
        $('.payment-status-select').each(function() {
            $(this).attr('data-payment', $(this).val());
        });
    }

    // Bulk selection functionality
    $('#selectAll').on('change', function() {
        $('.order-checkbox').prop('checked', this.checked);
        updateBulkActions();
    });

    $('.order-checkbox').on('change', function() {
        updateBulkActions();
    });

    function updateBulkActions() {
        const selected = $('.order-checkbox:checked').length;
        $('#selectedCount').text(selected);
        
        if (selected > 0) {
            $('#bulkActions').addClass('show');
        } else {
            $('#bulkActions').removeClass('show');
        }
    }

    $('#clearSelection').on('click', function() {
        $('.order-checkbox').prop('checked', false);
        $('#selectAll').prop('checked', false);
        updateBulkActions();
    });

    $('#applyBulkChanges').on('click', function() {
        const selectedOrders = $('.order-checkbox:checked').map(function() {
            return this.value;
        }).get();

        const orderStatus = $('#bulkOrderStatus').val();
        const paymentStatus = $('#bulkPaymentStatus').val();

        if (selectedOrders.length === 0) {
            toastr.error('Please select at least one order');
            return;
        }

        if (!orderStatus && !paymentStatus) {
            toastr.error('Please select a status to update');
            return;
        }

        // Update order status
        if (orderStatus) {
            $.ajax({
                url: "{{ route('order.bulkUpdateStatus') }}",
                type: 'POST',
                data: {
                    order_ids: selectedOrders,
                    status: orderStatus,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if(response.success) {
                        toastr.success(response.message);
                        location.reload();
                    }
                },
                error: function() {
                    toastr.error('Failed to update order status');
                }
            });
        }

        // Update payment status
        if (paymentStatus) {
            $.ajax({
                url: "{{ route('order.bulkUpdatePayment') }}",
                type: 'POST',
                data: {
                    order_ids: selectedOrders,
                    payment_status: paymentStatus,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if(response.success) {
                        toastr.success(response.message);
                        if (!orderStatus) location.reload();
                    }
                },
                error: function() {
                    toastr.error('Failed to update payment status');
                }
            });
        }
    });
});
</script>
@endpush