{{-- resources/views/back-end/review/edit.blade.php --}}
@extends('back-end.master')

@section('admin-title')
Edit Review
@endsection

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Review</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('review.index') }}">Reviews</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Update Review</h4>
                <a href="{{ route('review.index') }}" class="btn btn-sm btn-success">
                    <i class="fa fa-eye"></i> Manage
                </a>
            </div>

            <form class="form-horizontal" action="{{ route('review.update', $review->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="col-lg-8">

                        <div class="form-group row">
                            <label for="title" class="col-sm-3 text-end control-label col-form-label">Title (optional)</label>
                            <div class="col-sm-9">
                                <input type="text" name="title" id="title" class="form-control"
                                       value="{{ old('title', $review->title) }}"
                                       placeholder="Internal label (e.g., 'Amrita's Review')">
                                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="embed_code" class="col-sm-3 text-end control-label col-form-label">Embed Code *</label>
                            <div class="col-sm-9">
                                <textarea name="embed_code" id="embed_code" rows="6" class="form-control" required>{{ old('embed_code', $review->embed_code) }}</textarea>
                                @error('embed_code') <span class="text-danger">{{ $message }}</span> @enderror
                                <small class="text-muted d-block mt-2">
                                    Paste the full Facebook <iframe> embed code here.
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="all_review_link" class="col-sm-3 text-end control-label col-form-label">All Reviews Link</label>
                            <div class="col-sm-9">
                                <input type="url" name="all_review_link" id="all_review_link" class="form-control"
                                       value="{{ old('all_review_link', $review->all_review_link) }}"
                                       placeholder="https://facebook.com/yourpage/reviews">
                                @error('all_review_link') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="order" class="col-sm-3 text-end control-label col-form-label">Order</label>
                            <div class="col-sm-9">
                                <input type="number" name="order" id="order" class="form-control"
                                       value="{{ old('order', $review->order) }}" placeholder="0">
                                @error('order') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status" class="col-sm-3 text-end control-label col-form-label">Status</label>
                            <div class="col-sm-9 d-flex align-items-center">
                                <input type="checkbox" name="status" id="status" value="1" {{ old('status', $review->status) ? 'checked' : '' }}>
                                <label for="status" class="mb-0 ms-2">Active</label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 text-end control-label col-form-label">Preview</label>
                            <div class="col-sm-9">
                                <div class="border rounded p-2" style="max-width:520px;overflow:hidden">
                                    {!! $review->embed_code !!}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
