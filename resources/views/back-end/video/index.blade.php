<!-- resources/views/back-end/video/index.blade.php -->

@extends('back-end.master')
@section('admin-content')
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Video Section</h4>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addVideoModal">
                            <i class="fas fa-plus-circle me-2"></i>Add New Video
                        </button>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Videos Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th width="15%">Thumbnail</th>
                                        <th>Title</th>
                                        <th>Subtitle</th>
                                        <th width="10%">Status</th>
                                        <th width="15%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($videos))
                                        @foreach($videos as $videoItem)
                                            <tr>
                                                <td>
                                                    <!-- Change your image src in the view -->
                                                    <img src="{{ $videoItem->thumbnail ? asset('/storage/public/video/' . $videoItem->thumbnail) : asset('frontend/images/no-image.jpg') }}"
                                                        alt="Thumbnail" class="img-thumbnail"
                                                        style="width: 100px; height: 60px; object-fit: cover;">
                                                <td>{{ $videoItem->title ?? 'No Title' }}</td>
                                                <td>{{ $videoItem->subtitle ?? 'No Subtitle' }}</td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" class="form-check-input status-switch"
                                                            data-id="{{ $videoItem->id }}" {{ $videoItem->status ? 'checked' : '' }}>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-info me-2" data-bs-toggle="modal"
                                                        data-bs-target="#editVideoModal{{ $videoItem->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form action="{{ route('video-section.destroy', $videoItem->id) }}"
                                                        method="POST" style="display:inline;"
                                                        onsubmit="return confirm('Are you sure you want to delete this video?')">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>

                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <i class="fas fa-film text-muted mb-2" style="font-size: 2rem;"></i>
                                                <p class="text-muted mb-0">No videos found. Add your first video by clicking the
                                                    "Add New Video" button above.</p>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Video Modal -->
    <div class="modal fade" id="addVideoModal" tabindex="-1" aria-labelledby="addVideoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addVideoModalLabel">Add New Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('video-section.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                    required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Subtitle</label>
                                <input type="text" name="subtitle"
                                    class="form-control @error('subtitle') is-invalid @enderror">
                                @error('subtitle')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">YouTube Video URL <span class="text-danger">*</span></label>
                                <input type="url" name="video_url"
                                    class="form-control @error('video_url') is-invalid @enderror" required>
                                <small class="text-muted">Example: https://www.youtube.com/watch?v=VIDEO_ID</small>
                                @error('video_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Thumbnail Image</label>
                                <input type="file" name="thumbnail"
                                    class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*">
                                <small class="text-muted">Recommended size: 1280x720 pixels</small>
                                @error('thumbnail')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" name="status" id="addStatusSwitch"
                                        checked>
                                    <label class="form-check-label" for="addStatusSwitch">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Save Video
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Video Modals -->
    @if(isset($videos) && $videos->isNotEmpty())
        @foreach($videos as $videoItem)
            <div class="modal fade" id="editVideoModal{{ $videoItem->id }}" tabindex="-1"
                aria-labelledby="editVideoModalLabel{{ $videoItem->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editVideoModalLabel{{ $videoItem->id }}">Edit Video</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('video-section.update', $videoItem->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('POST')

                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                            value="{{ $videoItem->title }}" required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Subtitle</label>
                                        <input type="text" name="subtitle"
                                            class="form-control @error('subtitle') is-invalid @enderror"
                                            value="{{ $videoItem->subtitle }}">
                                        @error('subtitle')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">YouTube Video URL <span class="text-danger">*</span></label>
                                        <input type="url" name="video_url"
                                            class="form-control @error('video_url') is-invalid @enderror"
                                            value="{{ $videoItem->video_url }}" required>
                                        @error('video_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Thumbnail Image</label>
                                        <input type="file" name="thumbnail"
                                            class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*">
                                        @error('thumbnail')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @if($videoItem->thumbnail)
                                            <div class="mt-2">
                                                <img src="{{ asset('/public/storage/video/' . $videoItem->thumbnail) }}"
                                                    alt="Current Thumbnail" class="img-thumbnail" style="max-height: 150px;">
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input type="checkbox" class="form-check-input" name="status"
                                                id="editStatusSwitch{{ $videoItem->id }}" {{ $videoItem->status ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="editStatusSwitch{{ $videoItem->id }}">Active</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Update Video
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    @push('admin-scripts')
        <script>
            <script>
        // Status Toggle
        document.querySelectorAll('.status-switch').forEach(switch => {
            switch.addEventListener('change', function() {
                const videoId = this.dataset.id;
                const status = this.checked ? 1 : 0;

                fetch("{{ route('video-section.updateStatus') }}", {
                    method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                body: JSON.stringify({
                    video_id: videoId,
                status: status
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                    toastr.success('Status updated successfully');
                    } else {
                    toastr.error('Failed to update status');
                // Revert switch if failed
                this.checked = !status;
                    }
                })
                .catch(error => {
                    toastr.error('An error occurred');
                // Revert switch if error
                this.checked = !status;
                });
            });
        });

            // Video delete is now handled by POST forms above

        </script>
    @endpush
@endsection