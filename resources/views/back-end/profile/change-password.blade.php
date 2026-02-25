@extends('back-end.master')

@section('admin-title')
 Change Password
@endsection

@push('admin-styles')
<style>
   .card{
        border-radius: 0;
    }
    h4.card-title{
    font-size: 18px!important;
}
.card-body .btn-primary {
  margin-left: 170px;
}
</style>
@endpush

@section('admin-content')

<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Change Password </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Change Password </li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
      <div class="card">

          <div class="card-header">
            <h4 class="card-title">
               Change Password 
            </h4>
          </div>
                <form class="form-horizontal" action="{{ route('profile.change.password.updated') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="card-body">

                   <div class="col-lg-8">
                      <div class="form-group row">
                      <label
                        for="name"
                        class="col-sm-3 control-label col-form-label">New Password</label>
                      <div class="col-sm-9">
                        <input type="password" name="new_password" class="form-control" id="name" placeholder="New Password" value="{{ old('new_password') }}"/>
                        @error('new_password')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>


                    <div class="form-group row">
                      <label
                        for="name"
                        class="col-sm-3 control-label col-form-label">Confirm Password</label>
                      <div class="col-sm-9">
                        <input type="password" name="confirm_password" class="form-control" id="name" placeholder="Confirm Password" />
                         @error('confirm_password')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                   </div>


                  </div>
                  <div class="border-top">
                    <div class="card-body">
                      <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fa fa-paper-plane"></i> Change Password
                      </button>
                    </div>
                  </div>
                </form>
              </div>
             
              
            </div>
      </div>
 
@endsection

@push('admin-styles')
<style>
    .form-area{
    padding:30px 0px;
    background: #fff;
  }

  .card-footer button {
  background: yellow;
  border: none;
  color: #000;
  padding: 6px 30px;
  border-radius: 20px;
  font-size: 18px;
  margin-left: 260px!important;
}
</style>
@endpush