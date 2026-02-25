@extends('back-end.master')

@section('admin-title')
Product Details
@endsection



@section('admin-content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Product Variants List</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="bg-light">
                    <tr>
                        <th>#</th>
                        <th>Product Name</th>
                        <th>Size</th>
                        <th>SKU</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach($variants as $variant)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('uploads/products/' . $variant->product->product_image) }}" 
                                         alt="{{ $variant->product->product_name }}" 
                                         class="img-thumbnail me-2"
                                         style="width: 40px; height: 40px; object-fit: cover;">
                                    <span>{{ $variant->product->product_name }}</span>
                                </div>
                            </td>
                            <td>{{ $variant->size->name ?? 'N/A' }}</td>
                            <td><code>{{ $variant->sku }}</code></td>
                            <td>
                                @if($variant->stock_quantity <= 10)
                                    <span class="text-danger fw-bold">{{ $variant->stock_quantity }}</span>
                                @else
                                    {{ $variant->stock_quantity }}
                                @endif
                            </td>
                            <td>
                                {{-- <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input status-switch" 
                                           data-id="{{ $variant->id }}"
                                           {{ $variant->status ? 'checked' : '' }}>
                                </div> --}}
                                <label class="switch">
                                    <input type="checkbox" class="status-switch" 
                                           data-id="{{ $variant->id }}"
                                           {{ $variant->status ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td>
                                {{-- <button type="button" class="btn btn-sm btn-info edit-variant" 
                                        data-id="{{ $variant->id }}"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editVariantModal">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <a href="" 
                                   class="btn btn-sm btn-danger delete-variant">
                                    <i class="fa fa-trash"></i>
                                </a> --}}
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
    $('.status-switch').on('change', function() {
        const varientId = $(this).data('id');
        const isChecked = $(this).is(':checked');
        
        $.ajax({
            url: "{{ route('product.varient.updateStatus') }}", // You'll need to create this route
            type: 'POST',
            data: {
                id: varientId,
                status: isChecked ? 1 : 0,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if(response.success) {
                    toastr.success('Status updated successfully!');
                } else {
                    toastr.error('Failed to update status!');
                }
            },
            error: function() {
                toastr.error('Something went wrong!');
                // Revert the switch if the request failed
                $(this).prop('checked', !isChecked);
            }
        });
    });
});
</script>
@endpush