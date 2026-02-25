@extends('back-end.master')

@section('admin-title')
All Users
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
            <h1 class="m-0">Users </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Users</li>
            </ol>
          </div>
        </div>
      </div>
  </div>

  <div class="card">

      <div class="card-header">
          <h4 class="card-title aaa">
            Manage Unit
             {{-- <a href="" class="add_new_btn btn btn-sm btn-primary">
              <i class="fa fa-plus"></i>
                Add New
              </a> --}}
          </h4>
      </div>

          <div class="card-body">
            <div class="table-responsive">
                <table id="zero_config" class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Make Admin/User</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($item as $key => $items)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <img src="{{ !empty($items->image) 
                                        ? asset('storage/' . $items->image)
                                        : asset('frontend/images/default.jpg') }}"
                                        alt="Profile Picture"
                                        class="rounded-circle"
                                        style="width: 50px; height: 50px; object-fit: cover;">
                                </td>
                                <td>{{ $items->name ?? 'No Name' }}</td>
                                <td>{{ $items->email ?? 'No Email' }}</td>
                                <td>{{ $items->phone ?? 'No Phone' }}</td>











                                <td>
                                    <span class="badge {{ $items->status == 1 ? 'bg-success' : 'bg-info' }}">
                                        {{ $items->role == 1 ? 'Admin' : 'User' }}
                                    </span>
                                </td>





                                <td>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" 
                                               class="form-check-input role-switch" 
                                               data-id="{{ $items->id }}"
                                               {{ $items->role == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label">
                                            {{ $items->role == 1 ? 'Make User' : 'Make Admin' }}
                                        </label>
                                    </div>
                                </td>







                                <td>
                                    <button title="Action" class="btn without-focus border-0 px-1 py-0 mr-2" 
                                            type="button" id="dropdownMenuButton" 
                                            data-toggle="dropdown" 
                                            aria-haspopup="true" 
                                            aria-expanded="false">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        {{-- <a class="dropdown-item" href="">
                                            <i class="fa fa-edit"></i> Edit
                                        </a> --}}
                                        <form action="{{ route('delete.users',$items->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No Users Found</td>
                            </tr>
                        @endforelse
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
    $('.role-switch').change(function() {
        let userId = $(this).data('id');
        let isAdmin = $(this).prop('checked');
        
        console.log('User ID:', userId);
        console.log('Is Admin:', isAdmin);
        
        $.ajax({
            url: "{{ route('user.change.role') }}",
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                user_id: userId,
                role: isAdmin ? 1 : 0
            },

           
            success: function(response) {
                console.log('Response:', response);
                if(response.success) {
                    toastr.success('Role updated successfully');
                    location.reload();
                } else {
                    toastr.error('Failed to update role');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                toastr.error('Failed to update role');
            }
        });
    });
});
</script>
@endpush