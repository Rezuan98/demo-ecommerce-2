
@extends('back-end.master')

@section('admin-title')
subcategory
@endsection

@push('admin-styles')
<style>
	.card{
        border-radius: 0;
    }
    h4.card-title{
    font-size: 18px!important;
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

</style>
@endpush

@section('admin-content')

  <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Color</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Color</li>
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

              <a href="{{ route('color.index') }}" class="view_btn btn btn-sm btn-success">
              <i class="fa fa-eye"></i>
                Manage
              </a> 
             </h4>
         </div>

          <form class="form-horizontal" action="{{ route('color.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
              <div class="card-body">
                  <div class="col-sm-8">
                      <!-- Category Dropdown -->
                     

                    <div class="form-group row">
                      <label for="color_name" class="col-sm-3 text-end control-label col-form-label">Color Name</label>
                      <div class="col-sm-9">
                          <input type="text" name="name" class="form-control" id="color_name" placeholder="color..." />
                          @error('name')
                          <span class="text-danger">{{ $message }}</span>
                          @enderror
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="cat_name" class="col-sm-3 text-end control-label col-form-label">Color Code(Hexa Code)</label>
                      <div class="col-sm-9">
                          <input type="text" name="code" class="form-control" id="code" placeholder="Color Code..." />
                          @error('code')
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


