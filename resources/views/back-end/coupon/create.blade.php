@extends('back-end.master')
@section('admin-title', 'Create Coupon')

@section('admin-content')
    <div class="card mt-3">
        <div class="card-header">
            <h4 class="card-title">Create Coupon</h4>
            <a href="{{ route('coupon.index') }}" class="btn btn-secondary btn-sm add_new_btn">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('coupon.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Coupon Code <span class="text-danger">*</span></label>
                            <input type="text" name="code" class="form-control" value="{{ old('code') }}"
                                placeholder="e.g. SAVE20" style="text-transform: uppercase;" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Discount Type <span class="text-danger">*</span></label>
                            <select name="discount_type" class="form-control" required>
                                <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Fixed Amount (৳)
                                </option>
                                <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>
                                    Percentage (%)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Discount Amount <span class="text-danger">*</span></label>
                            <input type="number" name="discount_amount" class="form-control"
                                value="{{ old('discount_amount') }}" step="0.01" min="0.01" required>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Minimum Order Amount</label>
                            <input type="number" name="min_order_amount" class="form-control"
                                value="{{ old('min_order_amount') }}" step="0.01" min="0" placeholder="Optional">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Maximum Uses</label>
                            <input type="number" name="max_uses" class="form-control" value="{{ old('max_uses') }}" min="1"
                                placeholder="Unlimited if empty">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Status</label>
                            <div class="mt-2">
                                <label class="switch">
                                    <input type="checkbox" name="status" checked>
                                    <span class="slider"></span>
                                </label>
                                <span class="ml-2">Active</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Start Date <span class="text-danger">*</span></label>
                            <input type="date" name="start_date" class="form-control"
                                value="{{ old('start_date', date('Y-m-d')) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>End Date <span class="text-danger">*</span></label>
                            <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}" required>
                        </div>
                    </div>
                </div>

                <div class="card-footer mt-3">
                    <button type="submit" class="btn btn-primary">Create Coupon</button>
                </div>
            </form>
        </div>
    </div>
@endsection