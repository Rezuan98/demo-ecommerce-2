@extends('back-end.master')

@section('admin-title')
Edit Secondary Banner
@endsection

@push('admin-styles')
<style>
    .current-image {
        max-width: 200px;
        border: 1px solid #ddd;
        padding: 5px;
        border-radius: 4px;
    }
    
    .preview-container {
        position: relative;
        display: inline-block;
    }
    
    .preview-container img {
        max-height: 200px;
        object-fit: contain;
    }
</style>
@endpush

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Secondary Banner</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('secondary-banner.index') }}">Secondary Banners</a></li>
                    <li class="breadcrumb-item active">Edit Banner</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Edit Banner</h4>
            <a href="{{ route('secondary-banner.index') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('secondary-banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title">Banner Title</label>
                        <input type="text" 
                               class="form-control @error('title') is-invalid @enderror" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $banner->title) }}"
                               placeholder="Enter banner title">
                        @error('title')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="link">Banner Link (Optional)</label>
                        <input type="url" 
                               class="form-control @error('link') is-invalid @enderror" 
                               id="link" 
                               name="link" 
                               value="{{ old('link', $banner->link) }}"
                               placeholder="Enter banner link">
                        @error('link')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="position">Banner Position</label>
                        <select class="form-control @error('position') is-invalid @enderror" 
                                id="position" 
                                name="position">
                            <option value="0" {{ old('position', $banner->position) == '0' ? 'selected' : '' }}>Left</option>
                            <option value="1" {{ old('position', $banner->position) == '1' ? 'selected' : '' }}>Right</option>
                        </select>
                        @error('position')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="image">Banner Image</label>
                        <input type="file" 
                               class="form-control @error('image') is-invalid @enderror" 
                               id="image" 
                               name="image"
                               accept="image/*"
                               onchange="previewImage(this)">
                        <small class="form-text text-muted">Leave empty to keep current image</small>
                        @error('image')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-12 mt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-3">Current Image</h5>
                            <div class="preview-container">
                                <img src="{{ asset('storage/public/secondary-banners/' . $banner->image) }}" 
                                     alt="Current Banner" 
                                     class="current-image">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="mb-3">New Image Preview</h5>
                            <div id="imagePreview" class="preview-container" style="display: none;">
                                <img src="" alt="Preview Image" class="current-image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Banner
                </button>
                <a href="{{ route('secondary-banner.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('admin-scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const previewImg = preview.querySelector('img');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.style.display = 'none';
    }
}

// Check file size before upload
document.getElementById('image').addEventListener('change', function() {
//     if (this.files[0].size > 2048000) {
//         alert('File size must be less than 2MB');
//         this.value = '';
//         document.getElementById('imagePreview').style.display = 'none';
//     }
// });
</script>
@endpush