@extends('back-end.master')

@section('admin-title')
Message Details
@endsection

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Message Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('messages.index') }}">Messages</a></li>
                    <li class="breadcrumb-item active">Message Details</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Message Information</h4>
            <a href="{{ route('messages.index') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left mr-1"></i> Back to Messages
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 200px;">Sender Name</th>
                        <td>{{ $message->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $message->email }}</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>{{ $message->phone }}</td>
                    </tr>
                    <tr>
                        <th>Subject</th>
                        <td>{{ $message->subject }}</td>
                    </tr>
                    <tr>
                        <th>Sent Date</th>
                        <td>{{ $message->created_at->format('d M Y, h:i A') }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($message->is_read)
                                <span class="badge badge-success">Read</span>
                            @else
                                <span class="badge badge-warning">Unread</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <div class="message-content p-4 bg-light rounded">
                    <h5 class="mb-3">Message Content:</h5>
                    <p class="text-muted mb-0" style="white-space: pre-line;">{{ $message->message }}</p>
                </div>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-between">
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                <i class="fas fa-trash mr-1"></i> Delete Message
            </button>
            @if(!$message->is_read)
                <form action="{{ route('messages.mark-read', $message->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check mr-1"></i> Mark as Read
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this message?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form action="{{ route('messages.destroy', $message->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('admin-styles')
<style>
    .message-content {
        border: 1px solid #dee2e6;
        min-height: 200px;
    }
    
    .table th {
        background-color: #f8f9fa;
    }
    
    @media (max-width: 768px) {
        .message-content {
            margin-top: 20px;
        }
    }
</style>
@endpush