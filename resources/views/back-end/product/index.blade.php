@extends('back-end.master')

@section('admin-title')
    Manage Product
@endsection

@push('admin-styles')
    <style>
        .card {
            border-radius: 0;
        }

        .table thead tr th {
            background: #f5f5f5;
        }

        .table thead tr th,
        .table thead tr td {
            font-size: 14px;
        }

        .supplier-information {
            border: 1px solid rgba(0, 0, 0, .1);
            margin-bottom: 20px;
            padding: 5px 10px;
        }

        label {
            display: inline-block;
            margin-bottom: .5rem;
            font-size: 14px;
        }

        h4.card-title {
            font-size: 18px !important;
        }
    </style>
@endpush

@section('admin-content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Product</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Product</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="card">

        <div class="card-header d-flex justify-content-between">
            <div class="left">
                <h4 class="card-title">Manage Product</h4>
            </div>
            <div class="right">
                <a href="{{ route('product.create') }}" class="btn btn-info btn-sm">
                    <i class="fas fa-upload"></i> Add Product
                </a>
            </div>
            <div class="third">
                <a href="{{ route('product.bulk.create') }}" class="btn btn-info btn-sm">
                    <i class="fas fa-upload"></i> Bulk Upload
                </a>
            </div>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table id="zero_config" class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Category</th>
                            <th>Subcategory</th>

                            <th>Unit</th>
                            <th>Discount</th>
                            <th>Sale Price</th>
                            <th>Status</th>
                            <th>Featured</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach($lists as $info)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>
                                    <img src="{{ asset('uploads/products/' . $info->product_image) }}"
                                        alt="{{ $info->product_name }}" class="img-thumbnail"
                                        style="width: 50px; height: 50px; object-fit: cover;">
                                </td>
                                <td>{{ $info->product_name }}</td>
                                <td>{{ $info->product_code }}</td>
                                <td>{{ $info->category->name ?? 'N/A' }}</td>
                                <td>{{ $info->subcategory->name ?? 'N/A' }}</td>

                                <td>{{ $info->unit->name ?? 'N/A' }}</td>
                                <td>
                                    @if($info->discount_type)
                                        {{ number_format($info->discount_amount) }}
                                        {{ $info->discount_type === 'percentage' ? '%' : '$' }}
                                    @else
                                        No Discount
                                    @endif
                                </td>
                                <td>{{ number_format($info->sale_price, 0) }}</td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" class="status-switch" data-id="{{ $info->id }}" {{ $info->status ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" class="featured-switch" data-id="{{ $info->id }}" {{ $info->featured ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <button title="Action" class="btn without-focus border-0 px-1 py-0 mr-2" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </button>

                                    <div class="dropdown-menu" role="menu" style="">

                                        <a class="dropdown-item" href="{{ route('product.view.details', $info->id) }}">
                                            <i class="fa fa-eye"></i> Varient
                                        </a>

                                        <a class="dropdown-item" href="{{ route('product.edit', $info->id) }}">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>

                                        <form action="{{ route('product.delete', $info->id) }}" method="POST"
                                            style="display:inline;"
                                            onsubmit="return confirm('Are you sure you want to delete this?')">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </form>

                                        <form action="{{ route('product.duplicate', $info->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-info btn-sm">
                                                <i class="fa fa-copy"></i> Duplicate
                                            </button>
                                        </form>

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

{{-- @push('admin-scripts')

@endpush --}}

@push('admin-scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.status-switch').on('change', function () {
                const productId = $(this).data('id');
                const isChecked = $(this).is(':checked');

                $.ajax({
                    url: "{{ route('product.updateStatus') }}", // You'll need to create this route
                    type: 'POST'
                    , data: {
                        id: productId
                        , status: isChecked ? 1 : 0
                        , _token: '{{ csrf_token() }}'
                    }
                    , success: function (response) {
                        if (response.success) {
                            toastr.success('Status updated successfully!');
                        } else {
                            toastr.error('Failed to update status!');
                        }
                    }
                    , error: function () {
                        toastr.error('Something went wrong!');
                        // Revert the switch if the request failed
                        $(this).prop('checked', !isChecked);
                    }
                });
            });
        });

    </script>

    <script>
        $(document).ready(function () {
            $('.featured-switch').on('change', function () {
                const $checkbox = $(this);
                const productId = $checkbox.data('id');
                const isChecked = $checkbox.is(':checked');

                // Optional test alert
                // alert('ok');

                $.ajax({
                    url: "{{ route('product.featuredUpdate') }}"
                    , type: 'POST'
                    , data: {
                        id: productId
                        , featured: isChecked ? 1 : 0
                        , _token: '{{ csrf_token() }}'
                    }
                    , success: function (response) {
                        if (response.success) {
                            toastr.success('Featured updated successfully!');
                        } else {
                            toastr.error('Failed to update Featured!');
                        }
                    }
                    , error: function () {
                        toastr.error('Something went wrong!');
                        // Revert the switch if the request failed
                        $checkbox.prop('checked', !isChecked);
                    }
                });
            });
        });

    </script>
@endpush