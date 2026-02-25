@extends('back-end.master')

@section('admin-title')
    Bulk Upload Products
@endsection

@section('admin-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Bulk Upload Products</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Products</a></li>
                        <li class="breadcrumb-item active">Bulk Upload</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Upload CSV File</h3>
                        <a href="{{  asset('sample/product_bulk_template.csv')}}" class="btn btn-sm btn-info float-right">
                            Download Sample CSV
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('product.bulk.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="file">CSV File</label>
                                <input type="file" name="file" class="form-control @error('file') is-invalid @enderror"
                                    required>
                                @error('file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <p class="text-muted">
                                    <strong>Note:</strong> CSV file should contain the following columns:
                                    product_name, category_id, subcategory_id, brand_id, unit_id, description,
                                    sale_price, discount_type, discount_amount, size_id, stock_quantity
                                </p>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload Products</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection