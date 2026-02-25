@extends('frontend.master.master')

@section('keyTitle', 'Order Details')

@section('contents')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4">Order Details</h3>
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <div class="mb-4">
                        <h5 class="text-primary">Order #{{ $order->order_number }}</h5>
                        <p class="text-muted">Placed on {{ $order->created_at->format('M d, Y') }}</p>
                        <p><strong>Status:</strong>
                            <span class="badge bg-{{ 
                                $order->order_status === 'pending' ? 'warning' :
                                ($order->order_status === 'processing' ? 'info' :
                                ($order->order_status === 'shipped' ? 'primary' :
                                ($order->order_status === 'delivered' ? 'success' : 'danger')))
                            }}">
                                {{ ucfirst($order->order_status) }}
                            </span>
                        </p>
                    </div>

                    <h5 class="text-primary">Order Items</h5>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>Tk{{ number_format($item->price, 2) }}</td>
                                <td>Tk{{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <h5 class="text-primary mt-4">Order Summary</h5>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Subtotal:</span>
                            <strong>Tk{{ number_format($order->subtotal, 2) }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Shipping:</span>
                            <strong>Tk{{ number_format($order->shipping_cost, 2) }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between bg-light">
                            <span class="fw-bold">Total:</span>
                            <strong>Tk{{ number_format($order->total, 2) }}</strong>
                        </li>
                    </ul>
                    @if ($order->order_status === 'pending')
                    <div class="text-center mt-4">
                        <form action="{{ route('user.orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?');">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-times me-2"></i>Cancel Order
                            </button>
                        </form>
                    </div>
                    @endif

                    <div class="text-center mt-4">
                        <a href="{{ route('user.dashboard') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Orders
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
