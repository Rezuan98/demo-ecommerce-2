@extends('back-end.master')

@section('admin-title')
Change Password
@endsection

@push('admin-styles')
<style>
.card { border-radius: 0; }
h4.card-title { font-size: 18px!important; }
.form-group { margin-bottom: 1rem; }
label { display: inline-block; margin-bottom: .5rem; font-size: 14px; }
.form-control { border-radius: 4px; }
.btn { border-radius: 4px; }
</style>
@endpush

@section('admin-content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Change Password</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Change Password</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Change Your Password</h4>
            </div>

            <form action="{{ route('admin.update.password') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label for="current_password" class="col-sm-3 text-end control-label col-form-label">Current Password</label>
                        <div class="col-sm-9">
                            <input type="password" name="current_password" class="form-control" id="current_password" placeholder="Enter current password" required />
                            @error('current_password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="new_password" class="col-sm-3 text-end control-label col-form-label">New Password</label>
                        <div class="col-sm-9">
                            <input type="password" name="new_password" class="form-control" id="new_password" placeholder="Enter new password" required />
                            @error('new_password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="new_password_confirmation" class="col-sm-3 text-end control-label col-form-label">Confirm Password</label>
                        <div class="col-sm-9">
                            <input type="password" name="new_password_confirmation" class="form-control" id="new_password_confirmation" placeholder="Confirm new password" required />
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-key"></i>
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection