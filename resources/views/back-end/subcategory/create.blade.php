
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
            <h1 class="m-0">subcategory</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">subcategory</li>
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

              <a href="{{ route('subcategory.index') }}" class="view_btn btn btn-sm btn-success">
              <i class="fa fa-eye"></i>
                Manage
              </a> 
             </h4>
         </div>

          <form class="form-horizontal" action="{{ route('subcategory.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
              <div class="card-body">
                  <div class="col-sm-8">
                      <!-- Category Dropdown -->
                      <div class="form-group row">
                        <label class="col-sm-3 text-end control-label col-form-label" for="category">Select Category </label>
                        <div class="col-sm-9">
                          <select name="category_id" id="category" class="form-control">
                            <option value="" disabled selected>Select a Category</option>
                            @foreach($allcategories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>

                    <div class="form-group row">
                      <label for="cat_name" class="col-sm-3 text-end control-label col-form-label">Subcategory Name</label>
                      <div class="col-sm-9">
                          <input type="text" name="name" class="form-control" id="cat_name" placeholder="Name" />
                          @error('name')
                          <span class="text-danger">{{ $message }}</span>
                          @enderror
                      </div>
                    </div>

                      <div class="form-group row">
                      <label for="icon" class="col-sm-3 text-end control-label col-form-label">Thumbnail</label>
                      <div class="col-sm-9">
                          <input type="file" name="icon" class="form-control" id="thumbnail" placeholder="thumbnail" />
                          @error('icon')
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


