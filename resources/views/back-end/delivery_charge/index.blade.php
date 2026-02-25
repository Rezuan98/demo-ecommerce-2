@extends('back-end.master')

@section('admin-content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Manage Delivery Charges</h4>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Location Type</th>
                        <th>Charge (৳)</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($charges as $charge)
                    <tr>
                        <td>{{ str_replace('_', ' ', ucfirst($charge->location_type)) }}</td>
                        <td>
                            <form action="{{ route('delivery-charges.update', $charge) }}" method="POST" class="d-flex">
                                @csrf
                                @method('PUT')
                                <input type="number" name="charge" value="{{ $charge->charge }}" class="form-control" style="width: 100px">
                                <button type="submit" class="btn btn-primary btn-sm ms-2">Update</button>
                            </form>
                        </td>
                        <td>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input status-switch" 
                                       data-id="{{ $charge->id }}"
                                       {{ $charge->status ? 'checked' : '' }}>
                                <label class="custom-control-label"></label>
                            </div>
                        </td>
                        <td>
                            <button class="btn btn-info btn-sm" onclick="editCharge({{ $charge->id }})">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('admin-scripts')
<script>
$('.status-switch').change(function() {
    const chargeId = $(this).data('id');
    const status = $(this).prop('checked');

    $.ajax({
        url: `/admin/delivery-charges/${chargeId}/status`,
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            status: status
        },
        success: function(response) {
            toastr.success('Status updated successfully');
        },
        error: function() {
            toastr.error('Failed to update status');
        }
    });
});
</script>
@endpush
@endsection