@extends('back-end.master')

@section('admin-title')
Site Settings
@endsection

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Site Settings</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Site Settings</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">


                        
                        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Site Name -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Site Name</label>
                                        <input type="text" name="site_name" class="form-control" value="{{ $settings->site_name }}">
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" name="phone" class="form-control" value="{{ $settings->phone }}">
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" value="{{ $settings->email }}">
                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea name="address" class="form-control" rows="3">{{ $settings->address }}</textarea>
                                    </div>
                                </div>

                                <!-- Logo -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Logo</label>
                                        <input type="file" name="logo" class="form-control">
                                        @if($settings->logo)
                                            <img src="{{ asset('storage/' . $settings->logo) }}" alt="Current Logo" class="mt-2" style="max-height: 50px">
                                        @endif
                                    </div>
                                </div>

                                <!-- Favicon -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Favicon</label>
                                        <input type="file" name="favicon" class="form-control">
                                        @if($settings->favicon)
                                            <img src="{{ asset('storage/' . $settings->favicon) }}" alt="Current Favicon" class="mt-2" style="max-height: 32px">
                                        @endif
                                    </div>
                                </div>

                                <!-- Footer Description -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Footer Description</label>
                                        <textarea name="footer_description" class="form-control" rows="3">{{ $settings->footer_description }}</textarea>
                                    </div>
                                </div>

                                <!-- Social Media URLs -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Facebook URL</label>
                                        <input type="url" name="facebook_url" class="form-control" value="{{ $settings->facebook_url }}">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Instagram URL</label>
                                        <input type="url" name="instagram_url" class="form-control" value="{{ $settings->instagram_url }}">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Tiktok</label>
                                        <input type="url" name="youtube_url" class="form-control" value="{{ $settings->youtube_url }}">
                                    </div>
                                </div>
                            </div>

                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">Update Settings</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection