@extends('back-end.master')

@section('admin-title')
subcategory
@endsection

@push('admin-styles')
<style>
  .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
  }
  
  .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }
  
  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
  }
  
  .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: .4s;
  }
  
  input:checked + .slider {
    background-color: #2196F3;
  }
  
  input:checked + .slider:before {
    transform: translateX(26px);
  }
  
  .slider.round {
    border-radius: 34px;
  }
  
  .slider.round:before {
    border-radius: 50%;
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

  <div class="card">

      <div class="card-header">
          <h4 class="card-title aaa">
            Manage subcategory
             <a href="{{ route('subcategory.create') }}" class="add_new_btn btn btn-sm btn-primary">
              <i class="fa fa-plus"></i>
                Add New
              </a>
          </h4>
      </div>

          <div class="card-body">
            <div class="table-responsive">
              <table id="zero_config" class="table table-bordered text-center">
                <thead>
                  <tr>
                    <th>SN</th>
                    <th>Thumbnail</th>
                    <th>Subcategory Name</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                @foreach ($info as $item)
                    
              
                  <tr>
                    <td>{{ $item->id }}</td>
                    <td>
                   <img src="{{ asset('storage/'.$item->icon??'NO Image') }}" width="60" height="60" alt="">


                    </td>
                    <td>{{ $item->name?? 'NO Name' }}</td>
                    <td>
                      <label class="switch">
                          <input type="checkbox" class="status-switch" 
                                 data-id="{{ $item->id }}"
                                 {{ $item->status ? 'checked' : '' }}>
                          <span class="slider round"></span>
                      </label>
                  </td>
                   <!--  <td>
                        <a href="" class="btn btn-sm btn-primary text-white edit_btn">
                          <i class="fa fa-edit"></i>
                        </a>
                        <a href="" class="btn btn-sm btn-danger text-white delete_btn">
                          <i class="fa fa-trash"></i>
                        </a>
                    </td> -->
                    <td>
                       <button title="Action" class="btn without-focus border-0 px-1 py-0 mr-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-ellipsis-v"></i>
                        </button>

                              <div class="dropdown-menu" role="menu" style="">

                                 <a class="dropdown-item" href="{{ route('subcategory.edit',$item->id) }}">
                                  <i class="fa fa-edit"></i> Edit
                                </a>

                                 <form action="{{ route('subcategory.delete',$item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this?')">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </form>

                              </div>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
        </div>
  </div>
@endsection

@push('admin-scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $(document).on('change', '.status-switch', function() {
        const subcategoryId = $(this).data('id');
        const isChecked = $(this).is(':checked');
        const checkbox = $(this);

        $.ajax({
            url: "{{ route('subcategory.updateStatus') }}",
            type: 'POST',
            data: {
                subcategory_id: subcategoryId,
                status: isChecked ? 1 : 0,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if(response.success) {
                    toastr.success('Status updated successfully!');
                } else {
                    toastr.error('Failed to update status!');
                    checkbox.prop('checked', !isChecked);
                }
            },
            error: function() {
                toastr.error('Something went wrong!');
                checkbox.prop('checked', !isChecked);
            }
        });
    });
});
</script>
@endpush
