@extends('frontend.master.master')

@section('keyTitle', 'My Profile')
@push('ecomjs')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

</script>
@endpush
@section('contents')
<div class="container py-4">
    <div class="row g-4">
        <!-- Sidebar -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm">
                <!-- Profile Summary -->
                <div class="card-body text-center">
                    <div class="mb-3">
                        <img src="{{ !empty($user->image) 
                        ? asset('storage/' . $user->image)
                        : asset('frontend/images/defaultuser.png') }}" alt="Profile Picture" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                    </div>
                    <h5 class="mb-1">{{ $user->name }}</h5>
                    <p class="text-muted small">{{ $user->email }}</p>
                </div>
                <!-- Navigation Menu -->
                <div class="list-group list-group-flush">
                    <a href="#dashboard" class="list-group-item list-group-item-action active" data-bs-toggle="list">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>

                    {{-- <a href="#addresses" class="list-group-item list-group-item-action" data-bs-toggle="list">
                        <i class="fas fa-map-marker-alt me-2"></i>Addresses
                    </a> --}}
                    <a href="#account" class="list-group-item list-group-item-action" data-bs-toggle="list">
                        <i class="fas fa-user me-2"></i>Account Details
                    </a>
                    <a href="#changepassword" class="list-group-item list-group-item-action" data-bs-toggle="list">
                        <i class="fas fa-key me-2"></i>Change Password
                    </a>
                    <a href="{{ route('logout') }}" class="list-group-item list-group-item-action text-danger">
                       <form method="POST" action="{{ route('logout') }}" class="m-0">
    @csrf
    <button type="submit"
            class="list-group-item list-group-item-action text-danger w-100 text-start">
        <i class="fas fa-sign-out-alt me-2"></i> Logout
    </button>
</form>

                    </a>

             
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <div class="tab-content">
                <!-- Dashboard -->
                <div class="tab-pane fade show active" id="dashboard">
                    <h4 class="mb-4">Dashboard</h4>

                    <!-- Quick Stats -->
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6 col-md-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <h3 class="mb-1">{{ $totalOrders }}</h3>
                                    <p class="text-muted mb-0">Total Orders</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <h3 class="mb-1">{{ $activeOrders }}</h3>
                                    <p class="text-muted mb-0">Active Orders</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <h3 class="mb-1">৳{{ number_format($totalSpent, 2) }}</h3>
                                    <p class="text-muted mb-0">Total Spent</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Orders -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Recent Orders</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Order</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentOrders as $order)
                                    <tr>
                                        <td>#{{ $order->order_number }}</td>
                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <span class="badge bg-{{ 
                                                $order->order_status === 'pending' ? 'warning' :
                                                ($order->order_status === 'processing' ? 'info' :
                                                ($order->order_status === 'shipped' ? 'primary' :
                                                ($order->order_status === 'delivered' ? 'success' : 'danger')))
                                            }}">
                                                {{ ucfirst($order->order_status) }}
                                            </span>
                                        </td>
                                        <td>৳{{ number_format($order->total, 2) }}</td>
                                        <td>
                                            <a href="{{ route('user.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-3">
                                            <p class="text-muted mb-0">No orders found</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($recentOrders->isNotEmpty())
                        <div class="card-footer bg-white text-end">
                            <a href="{{ route('user.orders') }}" class="btn btn-link">View All Orders</a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Account Details -->
                <div class="tab-pane fade" id="account">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Account Details</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('user.profile.update') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <!-- Success Message -->
                                @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                                @endif

                                <!-- Error Message -->
                                @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                                @endif

                                <div class="row g-3">
                                    <!-- Profile Image -->
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Profile Image</label>
                                        <div class="d-flex align-items-center gap-3">
                                            <img id="imagePreview" src="{{ !empty($user->image) 
                                                     ? asset('storage/' . $user->image)
                                                     : asset('frontend/images/defaultuser.png') }}" alt="Profile Picture" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                                            <div>
                                                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image" accept="image/*" onchange="previewImage(this)">
                                                @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="text-muted">Maximum file size: 2MB</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Basic Info -->
                                    <div class="col-md-6">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name ?? 'No Name' }}" required>
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email ?? 'No Email' }}" required>
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Phone</label>
                                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $user->phone ?? 'No phone' }}" required>
                                        @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Address</label>
                                        <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="3" required>{{ $user->address ?? 'no address' }}</textarea>
                                        @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>



                                    <!-- Submit Button -->
                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>

                <!-- Change Password -->
                <div class="tab-pane fade" id="changepassword">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Change Password</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('new.password.update') }}" method="POST">
                                @csrf

                                @if(session('password_success'))
                                <div class="alert alert-success alert-dismissible fade show">
                                    {{ session('password_success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                                @endif

                                @if(session('password_error'))
                                <div class="alert alert-danger alert-dismissible fade show">
                                    {{ session('password_error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                                @endif

                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label">Current Password</label>
                                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required>
                                        @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">New Password</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required> <!-- Changed from new_password to password -->
                                        @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Confirm New Password</label>
                                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required>
                                        @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Update Password</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@push('ecomcss')
<style>
    .list-group-item {
        border-radius: 0;
        border-left: none;
        border-right: none;
        padding: 12px 20px;
    }

    .list-group-item.active {
        background-color: #f8f9fa;
        border-color: #dee2e6;
        color: #0d6efd;
    }

    .list-group-item:first-child {
        border-top: none;
    }

    .tab-pane {
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @media (max-width: 991.98px) {
        .tab-content {
            margin-top: 1rem;
        }
    }

</style>
@endpush

@endsection
