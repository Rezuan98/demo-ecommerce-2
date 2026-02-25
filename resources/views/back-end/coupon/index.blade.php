@extends('back-end.master')
@section('admin-title', 'Manage Coupons')

@section('admin-content')
    <div class="card mt-3">
        <div class="card-header">
            <h4 class="card-title">Manage Coupons</h4>
            <a href="{{ route('coupon.create') }}" class="btn btn-primary btn-sm add_new_btn">
                <i class="fas fa-plus"></i> Add Coupon
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Type</th>
                            <th>Discount</th>
                            <th>Min Order</th>
                            <th>Usage</th>
                            <th>Validity</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($coupons as $key => $coupon)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td><strong>{{ $coupon->code }}</strong></td>
                                <td>{{ ucfirst($coupon->discount_type) }}</td>
                                <td>
                                    @if($coupon->discount_type === 'fixed')
                                        ৳{{ number_format($coupon->discount_amount, 0) }}
                                    @else
                                        {{ $coupon->discount_amount }}%
                                    @endif
                                </td>
                                <td>{{ $coupon->min_order_amount ? '৳' . number_format($coupon->min_order_amount, 0) : 'None' }}
                                </td>
                                <td>{{ $coupon->used_count }} / {{ $coupon->max_uses ?? '∞' }}</td>
                                <td>
                                    <small>
                                        {{ $coupon->start_date->format('d M Y') }} —
                                        {{ $coupon->end_date->format('d M Y') }}
                                    </small>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" class="status-switch" data-id="{{ $coupon->id }}" {{ $coupon->status ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                </td>
                                <td>
                                    <a href="{{ route('coupon.edit', $coupon->id) }}" class="btn btn-info btn-sm edit_btn">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('coupon.delete', $coupon->id) }}" method="POST"
                                        style="display:inline;" onsubmit="return confirm('Delete this coupon?')">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm delete_btn">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No coupons found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('admin-scripts')
        <script>
            $('.status-switch').change(function () {
                const couponId = $(this).data('id');
                const status = $(this).prop('checked');

                $.ajax({
                    url: '{{ route("coupon.updateStatus") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: couponId,
                        status: status
                    },
                    success: function (response) {
                        toastr.success('Status updated successfully');
                    },
                    error: function () {
                        toastr.error('Failed to update status');
                    }
                });
            });
        </script>
    @endpush
@endsection