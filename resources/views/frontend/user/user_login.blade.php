@extends('frontend.master.master')

@section('keyTitle', 'Login')
@push('ecomcss')
  <style>
  /* Custom CSS for responsive design */
.login-form {
    max-width: 100%;
}

/* Form control sizing */
.form-control {
    padding: 0.75rem 1rem;
    font-size: 1rem;
    border-radius: 8px;
    transition: all 0.2s ease;
}

/* Larger screens */
@media (min-width: 768px) {
    .form-control {
        padding: 1rem 1.25rem;
    }
}

/* Card styling */
.card {
    border: none;
    border-radius: 15px;
    background: #fff;
    transition: transform 0.2s ease;
}

/* Shadow effects */
.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

/* Button styling */
.btn-primary {
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    border-radius: 8px;
    transition: all 0.2s ease;
}

/* Hover state */
.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(13, 110, 253, 0.2);
}

/* Form label */
.form-label {
    font-weight: 500;
    margin-bottom: 0.5rem;
}

/* Password toggle cursor */
.cursor-pointer {
    cursor: pointer;
}

/* Small screen adjustments */
@media (max-width: 576px) {
    .card-body {
        padding: 1rem;
    }
    
    .btn-lg {
        padding: 0.75rem 1rem;
    }
    
    .form-control-lg {
        font-size: 16px; /* Prevents zoom on iOS */
    }
}

/* Medium screen and up */
@media (min-width: 768px) {
    .card {
        margin-top: 2rem;
    }
}
    </style>  
@endpush
@section('contents')
<div class="container py-3 py-md-5">
    <div class="row justify-content-center">
        <!-- On mobile full width, on tablet/desktop 6 columns -->
        <div class="col-12 col-md-8 col-lg-6">
            <!-- Card with responsive padding -->
            <div class="card shadow">
                <div class="card-header bg-white py-3 py-md-4">
                    <h4 class="text-center mb-0 fs-5 fs-md-4">Login to Your Account</h4>
                </div>
                <div class="card-body p-3 p-md-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="login-form">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" 
                                   class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autocomplete="email" 
                                   autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="position-relative">
                                <input type="password" 
                                       class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       required 
                                       autocomplete="current-password">
                                <span class="position-absolute top-50 end-0 translate-middle-y pe-3 cursor-pointer" 
                                      onclick="togglePassword()">
                                    <i class="fas fa-eye" id="togglePassword"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Two columns on larger screens -->
                        <div class="row mb-3 align-items-center">
                            <div class="col-12 col-sm-6 mb-2 mb-sm-0">
                                <div class="form-check">
                                    <input type="checkbox" 
                                           class="form-check-input" 
                                           id="remember" 
                                           name="remember" 
                                           {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                           
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" style="background-color: var(--third-color); color:#fff;" class="btn btn-lg">
                                Login
                            </button>
                        </div>
                        
                        <div class="text-center mt-4">
                            <p class="mb-0 mt-2">
                                Don't have an account? 
                                <a href="{{ route('user.register') }}" class="text-decoration-none">
                                    Register here
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add this at the end of your contents section -->
<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('togglePassword');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}
</script>
@endsection