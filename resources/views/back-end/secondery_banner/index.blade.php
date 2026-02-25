@extends('back-end.master')

@section('admin-title')
Secondary Banners
@endsection

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Secondary Banners</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Secondary Banners</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Manage Secondary Banners</h4>
            <a href="{{ route('secondary-banner.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Banner
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Position</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($banners as $banner)
                    <tr>
                        <td>
                            <img src="{{ asset('storage/public/secondary-banners/' . $banner->image) }}" 
                                 alt="{{ $banner->title }}" 
                                 style="height: 50px;">
                        </td>
                        <td>{{ $banner->title }}</td>
                        <td>{{ $banner->position == 0 ? 'Left' : 'Right' }}</td>
                        <td>
                            <label class="switch">
                                <input type="checkbox" 
                                       class="status-switch" 
                                       data-id="{{ $banner->id }}" 
                                       {{ $banner->status ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td>
                            <a href="{{ route('secondary-banner.edit', $banner->id) }}" 
                               class="btn btn-sm btn-info">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('secondary-banner.destroy', $banner->id) }}" 
                                  method="POST" 
                                  class="d-inline-block"
                                  onsubmit="return confirm('Are you sure you want to delete this banner?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No banners found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('admin-scripts')
<script>
$(document).ready(function() {
    $('.status-switch').on('change', function() {
        const bannerId = $(this).data('id');
        const isChecked = $(this).is(':checked');
        
        $.ajax({
            url: "{{ route('secondary-banner.updateStatus') }}",
            type: 'POST',
            data: {
                banner_id: bannerId,
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
                $(this).prop('checked', !isChecked);
            }
        });
    });
});
</script>
@endpush