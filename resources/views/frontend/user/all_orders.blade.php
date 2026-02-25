@extends('frontend.master.master')

@section('keyTitle', 'My Orders')
@push('ecomcss')
<style>
    .order-table {
        width: 100%;
        border-collapse: collapse;
    }

    .order-table th,
    .order-table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .order-table th {
        background-color: #f8f9fa;
    }

    .order-table tr:hover {
        background-color: #f1f1f1;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 14px;
    }

    .badge-warning {
        background-color: #ffc107;
        color: #000;
    }

    .badge-info {
        background-color: #17a2b8;
        color: #fff;
    }

    .badge-primary {
        background-color: #007bff;
        color: #fff;
    }

    .badge-success {
        background-color: #28a745;
        color: #fff;
    }

    .badge-danger {
        background-color: #dc3545;
        color: #fff;
    }

    .pagination {
        justify-content: center;
        margin-top: 20px;
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
    }

    .pagination .page-link {
        color: #007bff;
    }

</style>
@endpush

@section('contents')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">My Orders</h2>

            <!-- Orders Table -->
            <div class="table-responsive">
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>#{{ $order->order_number }}</td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                            <td>
                                <span class="badge bg-{{ 
                                    $order->order_status === 'pending' ? 'warning' :
                                    ($order->order_status === 'processing' ? 'info' :
                                    ($order->order_status === 'shipped' ? 'primary' :
                                    ($order->order_status === 'delivered' ? 'success' : 'danger')))
                                }}">
                                    {{ ucfirst($order->order_status) }}
                                </span>
                            </td>
                            <td>Tk{{ number_format($order->total, 2) }}</td>
                            <td>
                                <a href="{{ route('user.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-3">
                                <p class="text-muted mb-0">No orders found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($orders->hasPages())
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
