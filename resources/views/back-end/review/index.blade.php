@extends('back-end.master')

@section('admin-title')
    Reviews
@endsection

@section('admin-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Reviews</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Reviews</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Manage Reviews</h4>
            <a href="{{ route('review.create') }}" class="add_new_btn btn btn-sm btn-primary">
                <i class="fa fa-plus"></i> Add New
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="zero_config" class="table table-bordered text-center align-middle">
                    <thead>
                        <tr>
                            <th width="70">Order</th>
                            <th width="220">Title</th>
                            <th>Embed Preview</th>
                            <th width="110">Status</th>
                            <th width="150">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reviews as $review)
                            <tr>
                                <td>{{ $review->order }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $review->title ?? '—' }}</div>
                                    @if($review->all_review_link)
                                        <a href="{{ $review->all_review_link }}" target="_blank" class="small text-primary">All
                                            Reviews</a>
                                    @endif
                                </td>
                                <td class="text-start">
                                    <div class="border rounded p-2 d-inline-block" style="max-width:520px;overflow:hidden">
                                        {{-- Small, lazy preview (relies on FB allowing embed in admin area) --}}
                                        {!! preg_replace('/width="(\d+)"/i', 'width="520"', preg_replace('/height="(\d+)"/i', 'height="180"', $review->embed_code)) !!}
                                    </div>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" class="status-switch" data-id="{{ $review->id }}" {{ $review->status ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <a href="{{ route('review.edit', $review->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('review.delete', $review->id) }}" method="POST"
                                        style="display:inline;"
                                        onsubmit="return confirm('Are you sure you want to delete this review?')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        @if($reviews->isEmpty())
                            <tr>
                                <td colspan="5">No reviews found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('admin-scripts')
    <script>
        $(document).ready(function () {
            $('.status-switch').on('change', function () {
                const reviewId = $(this).data('id');
                const isChecked = $(this).is(':checked');
                const checkbox = $(this);

                $.ajax({
                    url: "{{ route('review.updateStatus') }}",
                    type: 'POST',
                    data: {
                        review_id: reviewId,
                        status: isChecked ? 1 : 0,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.success) {
                            toastr.success('Status updated successfully!');
                        } else {
                            toastr.error('Failed to update status!');
                            checkbox.prop('checked', !isChecked);
                        }
                    },
                    error: function () {
                        toastr.error('Something went wrong!');
                        checkbox.prop('checked', !isChecked);
                    }
                });
            });
        });
    </script>
@endpush