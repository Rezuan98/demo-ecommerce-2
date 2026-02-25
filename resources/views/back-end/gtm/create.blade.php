@extends('back-end.master')

@section('admin-title')
GTM
@endsection

@push('admin-styles')
<style>
    .card {
        border-radius: 0;
    }

    h4.card-title {
        font-size: 18px !important;
    }

    .table thead tr th {
        background: #f5f5f5;
    }

    .table thead tr th,
    .table thead tr td {
        font-size: 14px;
    }

    .supplier-information {
        border: 1px solid rgba(0, 0, 0, .1);
        margin-bottom: 20px;
        padding: 5px 10px;
    }

    label {
        display: inline-block;
        margin-bottom: .5rem;
        font-size: 14px;
    }

</style>
@endpush

@section('admin-content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">GTM CODE</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">GTM</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title aaa">
                    Add New

                    <a href="{{ route('gtm.index') }}" class="view_btn btn btn-sm btn-success">
                        <i class="fa fa-eye"></i>
                        Manage
                    </a>
                </h4>
            </div>

            <form class="form-horizontal" action="{{ route('gtm.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="col-sm-8">
                      <input type="hidden" name="id" value="{{ isset($data) ? $data->id : '' }}" id="">

                        <div class="form-group row">
                            <label for="cat_name" class="col-sm-3 text-end control-label col-form-label">GTM CODE</label>
                            <div class="col-sm-9">
                                <input type="text" name="gtm_code" value="{{ $data->code?? 'no  code' }}" class="form-control" id="cat_name" placeholder="code" />
                                @error('gtm_code')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>



                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-paper-plane"></i>
                        Submit
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection
