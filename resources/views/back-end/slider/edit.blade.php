@extends('back-end.master')

@section('admin-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Slider</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title', $slider->title) }}">
                                @error('title')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="subtitle" class="form-label">Subtitle</label>
                                <input type="text" class="form-control @error('subtitle') is-invalid @enderror" 
                                       id="subtitle" name="subtitle" value="{{ old('subtitle', $slider->subtitle) }}">
                                @error('subtitle')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                       id="image" name="image" accept="image/*">
                                @error('image')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                
                                <!-- Current Image Preview -->
                                @if($slider->image)
                                    <div class="mt-2">
                                        <label class="form-label">Current Image:</label>
                                        <img src="{{ asset('uploads/sliders/'.$slider->image) }}" 
                                             alt="Current Slider Image" 
                                             class="img-thumbnail" 
                                             style="max-height: 100px;">
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label for="link" class="form-label">Link URL (Optional)</label>
                                <input type="url" class="form-control @error('link') is-invalid @enderror" 
                                       id="link" name="link" value="{{ old('link', $slider->link) }}">
                                @error('link')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="order" class="form-label">Display Order</label>
                                <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                       id="order" name="order" value="{{ old('order', $slider->order) }}" min="0">
                                @error('order')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" 
                                           id="status" name="status" 
                                           {{ $slider->status ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status">Active</label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Update Slider</button>
                            <a href="{{ route('sliders.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('admin-scripts')
<script>
    // Preview image before upload
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.createElement('img');
                preview.src = e.target.result;
                preview.className = 'img-thumbnail mt-2';
                preview.style.maxHeight = '100px';
                
                const container = document.getElementById('image').parentElement;
                const oldPreview = container.querySelector('.img-thumbnail');
                if (oldPreview) {
                    oldPreview.parentElement.remove();
                }
                
                const previewDiv = document.createElement('div');
                previewDiv.className = 'mt-2';
                const previewLabel = document.createElement('label');
                previewLabel.className = 'form-label';
                previewLabel.textContent = 'New Image Preview:';
                
                previewDiv.appendChild(previewLabel);
                previewDiv.appendChild(preview);
                container.appendChild(previewDiv);
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
@endsection