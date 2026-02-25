
@extends('back-end.master')

@section('admin-title')
Product
@endsection

@push('admin-styles')
<style>
  .card{
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
                      <h4 class="card-title">Update subcategory</h4>
                    </div>
                    
                <form class="form-horizontal" action="{{ route('subcategory.update') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="card-body">
                   

                    <div class="col-sm-8">
                      <div class="form-group row">
                        <label class="col-sm-3 text-end control-label col-form-label" for="category">Select Category </label>
                        <div class="col-sm-9">
                          <select name="category_id" id="category" class="form-control">
                            <option value="" disabled selected>Select a Category</option>
                            @foreach($category as $categories)
                                <option value="{{ $categories->id }}"{{ $info->category_id == $categories->id ? 'selected' : '' }}>{{ $categories->name }}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                      <div class="form-group row">
                      <label for="fname" class="col-sm-3 text-end control-label col-form-label">Name</label>
                      <div class="col-sm-9">
                        <input
                          type="text" name="name"
                          class="form-control"
                          id="fname" value="{{ $info->name }}"
                          placeholder="Name"
                        />
                         @error('name')
                          <span class="text-danger">{{ $message }}</span>
                          @enderror
                      </div>
                    </div>

                    <input type="hidden" name="id" value="{{ $info->id }}">
                    </div>
   
                    <div class="col-sm-9">
                      <div class="form-group row">
                          <label for="icon" class="col-sm-3 text-end control-label col-form-label">Icon</label>
                          <div class="col-sm-9">
                              <!-- Image display area (will show either existing or new image) -->
                              <div class="mb-2">
                                  <img id="displayImage" 
                                       src="{{ asset('storage/'.$info->icon) }}" 
                                       alt="subcategory Icon" 
                                       style="max-width: 80px; max-height: 90px;">
                              </div>
                              
                              <!-- File input -->
                              <input type="file" name="icon" class="form-control" id="iconInput" 
                                     onchange="previewImage(this)"/>
                              
                              @error('icon')
                                  <span class="text-danger">{{ $message }}</span>
                              @enderror
                          </div>
                      </div>
                  </div>
                  
</div>

                  </div>
                  <div class="border-top">
                    <div class="card-body">
                      <button type="submit" class="btn btn-primary">
                        Update
                      </button>
                    </div>
                  </div>
                </form>
              </div>
  </div>
 </div>

 <script>
  function previewImage(input) {
      const display = document.getElementById('displayImage');
      
      if (input.files && input.files[0]) {
          const reader = new FileReader();
          
          reader.onload = function(e) {
              display.src = e.target.result;
          }
          
          reader.readAsDataURL(input.files[0]);
      }
  }
  </script>
@endsection