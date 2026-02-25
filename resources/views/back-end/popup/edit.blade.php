@extends('back-end.master')

@section('admin-title')
Edit Popup
@endsection

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Popup</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('popup.index') }}">Popups</a></li>
                    <li class="breadcrumb-item active">Edit</li>
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
                    Edit Popup
                    <a href="{{ route('popup.index') }}" class="view_btn btn btn-sm btn-success">
                        <i class="fa fa-eye"></i> Manage Popups
                    </a>
                </h4>
            </div>

            <form class="form-horizontal" action="{{ route('popup.update', $popup->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group row">
                                <label for="image" class="col-sm-3 text-end control-label col-form-label">
                                    Popup Image
                                </label>
                                <div class="col-sm-9">
                                    <input type="file" name="image" class="form-control" id="image" 
                                           accept="image/*" onchange="previewImage(this)">
                                    @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted">Leave empty to keep current image. Recommended size: 500x400px (JPG, PNG)</small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="link" class="col-sm-3 text-end control-label col-form-label">
                                    Link URL
                                </label>
                                <div class="col-sm-9">
                                    <input type="url" name="link" class="form-control" id="link" 
                                           placeholder="https://example.com" value="{{ old('link', $popup->link) }}">
                                    @error('link')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted">Where users will be redirected when clicking the popup</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Current/Preview Image</label>
                                <div class="preview-container" style="border: 2px dashed #ddd; padding: 20px; text-align: center; min-height: 200px;">
                                    <img id="imagePreview" 
                                         src="{{ asset('uploads/popups/' . $popup->image) }}" 
                                         alt="Current Image" 
                                         style="max-width: 100%; max-height: 200px;">
                                    <div id="previewPlaceholder" style="color: #999; margin-top: 50px; display: none;">
                                        <i class="fas fa-image fa-3x"></i>
                                        <p>Image preview will appear here</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Update Popup
                    </button>
                    <a href="{{ route('popup.index') }}" class="btn btn-secondary ms-2">
                        <i class="fa fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('admin-scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const placeholder = document.getElementById('previewPlaceholder');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush