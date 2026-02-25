<!-- index.blade.php -->
@extends('back-end.master')

@section('admin-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        Manage Sliders
                        <a href="{{ route('sliders.create') }}" class="btn btn-primary float-end">
                            <i class="fas fa-plus"></i> Add New Slider
                        </a>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Subtitle</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sliders as $slider)
                                <tr>
                                    <td>{{ $slider->order }}</td>
                                    <td>
                                        <img src="{{ asset('/uploads/sliders/'.$slider->image) }}" alt="Slider" style="height: 50px;">
                                    </td>
                                    <td>{{ $slider->title }}</td>
                                    <td>{{ $slider->subtitle }}</td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" class="status-switch" data-id="{{ $slider->id }}" {{ $slider->status ? 'checked' : '' }}>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <a href="{{ route('sliders.edit', $slider->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('sliders.destroy', $slider->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this slider?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('admin-scripts')
<script>
    $(document).ready(function() {
        $('.status-switch').on('change', function() {
            const sliderId = $(this).data('id');
            const isChecked = $(this).is(':checked');

            $.ajax({
                url: "{{ route('sliders.updateStatus') }}"
                , type: 'POST'
                , data: {
                    slider_id: sliderId
                    , status: isChecked ? 1 : 0
                    , _token: '{{ csrf_token() }}'
                }
                , success: function(response) {
                    if (response.success) {
                        toastr.success('Status updated successfully!');
                    } else {
                        toastr.error('Failed to update status!');
                    }
                }
                , error: function() {
                    toastr.error('Something went wrong!');
                }
            });
        });
    });

</script>
@endpush
