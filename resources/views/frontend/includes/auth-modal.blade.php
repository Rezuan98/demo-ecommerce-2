{{-- Auth Modal — Login/Register for guest users --}}
@guest
    <div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
                {{-- Header --}}
                <div class="modal-header border-0 pb-0"
                    style="background: var(--primary-color); color: #fff; padding: 24px 24px 16px;">
                    <h5 class="modal-title fw-bold" id="authModalLabel" style="font-family: var(--font-heading);">
                        Welcome
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                {{-- Tabs --}}
                <ul class="nav nav-tabs border-0 px-3 pt-2" id="authTab" role="tablist"
                    style="background: var(--primary-color);">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active text-white" id="login-tab" data-bs-toggle="tab"
                            data-bs-target="#loginPanel" type="button" role="tab"
                            style="border: none; border-bottom: 3px solid transparent; background: transparent; font-family: var(--font-heading);">
                            Login
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-white" id="register-tab" data-bs-toggle="tab"
                            data-bs-target="#registerPanel" type="button" role="tab"
                            style="border: none; border-bottom: 3px solid transparent; background: transparent; font-family: var(--font-heading);">
                            Register
                        </button>
                    </li>
                </ul>

                {{-- Tab Content --}}
                <div class="tab-content p-4">
                    {{-- Login Panel --}}
                    <div class="tab-pane fade show active" id="loginPanel" role="tabpanel">
                        <form id="authModalLoginForm" novalidate>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="you@example.com"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="remember" class="form-check-input" id="authRemember">
                                <label class="form-check-label small" for="authRemember">Remember me</label>
                            </div>
                            <button type="submit" class="btn w-100 fw-bold"
                                style="background: var(--primary-color); color: #fff; font-family: var(--font-heading); padding: 10px;">
                                Login
                            </button>
                        </form>
                    </div>

                    {{-- Register Panel --}}
                    <div class="tab-pane fade" id="registerPanel" role="tabpanel">
                        <form id="authModalRegisterForm" novalidate>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Full Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Your name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="you@example.com"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Phone</label>
                                <input type="text" name="phone" class="form-control" placeholder="01XXXXXXXXX" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Min 8 characters"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control"
                                    placeholder="Repeat password" required>
                            </div>
                            <button type="submit" class="btn w-100 fw-bold"
                                style="background: var(--primary-color); color: #fff; font-family: var(--font-heading); padding: 10px;">
                                Create Account
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Styles --}}
                <style>
                    #authTab .nav-link.active {
                        border-bottom-color: #fff !important;
                        font-weight: 700;
                    }

                    #authTab .nav-link:hover {
                        border-bottom-color: rgba(255, 255, 255, 0.5) !important;
                    }

                    #authModal .form-control:focus {
                        border-color: var(--primary-color);
                        box-shadow: 0 0 0 0.2rem rgba(79, 8, 8, 0.15);
                    }

                    /* Fixed height — modal doesn't resize between tabs */
                    #authModal .tab-content {
                        min-height: 420px;
                    }

                    /* Toast notifications */
                    .toast-notification {
                        position: fixed;
                        top: 20px;
                        right: 20px;
                        z-index: 99999;
                        padding: 14px 22px;
                        border-radius: 8px;
                        color: #fff;
                        font-size: 14px;
                        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
                        transform: translateX(120%);
                        transition: transform 0.3s ease;
                    }

                    .toast-notification.show {
                        transform: translateX(0);
                    }

                    .toast-notification.success {
                        background: #27ae60;
                    }

                    .toast-notification.error {
                        background: #e74c3c;
                    }

                    .toast-content {
                        display: flex;
                        align-items: center;
                        gap: 10px;
                    }
                </style>
            </div>
        </div>
    </div>
@endguest