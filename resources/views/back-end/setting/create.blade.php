@extends('back-end.master')

@section('admin-title')
{{ $create }}
@endsection

@push('admin-styles')
<style>
    / .card{
        border-radius: 0;
    }
  .table thead tr th{
    background: #f5f5f5;
   }

   .table thead tr th, .table thead tr td{
      font-size: 14px;
   }

    .supplier-information {
        border: 1px solid rgba(0,0,0,.1);
        margin-bottom: 20px;
        padding: 5px 10px;
    }
    label {
    display: inline-block;
    margin-bottom: .5rem;
    font-size: 14px;
}
h4.card-title{
    font-size: 18px!important;
}
</style>
@endpush

@section('admin-content')

<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Setting</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Setting</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

<div class="row">
    <div class="col-12 form-area">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                            <h4 class="card-title">{{ $create }}</h4>
                        </div>
                <form class="form-horizontal" action="{{ $action }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method($method === 'POST' ? 'POST' : 'PATCH')
                    <div class="card-body">
                        

                        <div class="form-group row">
                            <label for="name" class="col-sm-3 control-label col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input
                                    type="text" name="name"
                                    class="form-control"
                                    id="name"
                                    placeholder="Name"
                                    value="{{ $info->name ?? '' }}"
                                />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-sm-3 control-label col-form-label">Address</label>
                            <div class="col-sm-9">
                                <input
                                    type="text" name="address"
                                    class="form-control"
                                    id="address"
                                    placeholder="Address"
                                    value="{{ $info->address ?? '' }}"
                                />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-sm-3 control-label col-form-label">E-Mail</label>
                            <div class="col-sm-9">
                                <input
                                    type="email" name="email"
                                    class="form-control"
                                    id="email"
                                    placeholder="E-Mail"
                                    value="{{ $info->email ?? '' }}"
                                />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-sm-3 control-label col-form-label">Phone No</label>
                            <div class="col-sm-9">
                                <input
                                    type="text" name="phone"
                                    class="form-control"
                                    id="phone"
                                    placeholder="Phone No"
                                    value="{{ $info->phone ?? '' }}"
                                />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="logo" class="col-sm-3 control-label col-form-label">Logo</label>
                            <div class="col-sm-9">
                                <input type="file" name="logo" class="form-control"/>
                                <img src="{{ asset('/') }}back-end/setting/{{ $info->logo ?? '' }}" style="width:100px;height: 100px;margin-top:10px;">
                            </div>
                        </div>
                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary float-end">
                                <i class="fa fa-paper-plane"></i> {{ $btn_name }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
