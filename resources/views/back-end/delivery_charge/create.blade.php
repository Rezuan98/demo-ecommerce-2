@extends('back-end.master')

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Add Delivery Charge</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Add Delivery Charge</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title">
            Add New Delivery Charge
            <a href="{{ route('delivery-charges.index') }}" class="btn btn-sm btn-primary float-right">
                <i class="fa fa-list"></i> View List
            </a>
        </h4>
    </div>

    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('delivery-charges.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Location Type <span class="text-danger">*</span></label>
                        <select name="location_type" class="form-control @error('location_type') is-invalid @enderror">
                            <option value="">Select Location Type</option>
                            <option value="inside_dhaka" {{ old('location_type') == 'inside_dhaka' ? 'selected' : '' }}>Inside Dhaka</option>
                            <option value="outside_dhaka" {{ old('location_type') == 'outside_dhaka' ? 'selected' : '' }}>Outside Dhaka</option>
                            <option value="inside_dhaka(urgent)" {{ old('location_type') == 'inside_dhaka(urgent)' ? 'selected' : '' }}>Inside Dhaka(Urgent)</option>
                        </select>
                        @error('location_type')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Delivery Charge (৳) <span class="text-danger">*</span></label>
                        <input type="number" name="charge" value="{{ old('charge') }}" 
                               class="form-control @error('charge') is-invalid @enderror"
                               step="0.01" min="0">
                        @error('charge')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Status</label>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="status" name="status" value="1" checked>
                            <label class="custom-control-label" for="status">Active</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Save
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('admin-scripts')
<script>
$(document).ready(function() {
    // Add any JavaScript validations or enhancements here
});
</script>
@endpush