@extends('back-end.master')

@section('admin-title')
Popup Management
@endsection

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Popup Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Popups</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    All Popups
                    <a href="{{ route('popup.create') }}" class="add_new_btn btn btn-sm btn-primary">
                        <i class="fa fa-plus"></i> Add New
                    </a>
                </h4>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Image</th>
                                <th>Link</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($popups as $key => $popup)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <img src="{{ asset('uploads/popups/' . $popup->image) }}" 
                                         alt="Popup" class="img-thumbnail" 
                                         style="width: 80px; height: 60px; object-fit: cover;">
                                </td>
                                <td>
                                    @if($popup->link)
                                        <a href="{{ $popup->link }}" target="_blank" class="text-primary">
                                            {{ Str::limit($popup->link, 30) }}
                                        </a>
                                    @else
                                        <span class="text-muted">No Link</span>
                                    @endif
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" 
                                               onchange="updateStatus({{ $popup->id }}, this)" 
                                               {{ $popup->status ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                </td>
                                <td>{{ $popup->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('popup.edit', $popup->id) }}" 
                                       class="btn btn-sm btn-primary edit_btn">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-danger delete_btn"
                                            onclick="deletePopup({{ $popup->id }})">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No popups found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this popup?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('admin-scripts')
<script>
function updateStatus(popupId, element) {
    const status = element.checked ? 1 : 0;
    
    fetch(`{{ route('popup.updateStatus') }}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            popup_id: popupId,
            status: status
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            toastr.success(data.message);
        } else {
            toastr.error(data.message);
            element.checked = !element.checked; // Revert checkbox
        }
    })
    .catch(error => {
        console.error('Error:', error);
        toastr.error('Something went wrong!');
        element.checked = !element.checked; // Revert checkbox
    });
}

function deletePopup(popupId) {
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `{{ route('popup.destroy', '') }}/${popupId}`;
    
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}
</script>
@endpush