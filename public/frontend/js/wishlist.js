/**
 * Wishlist JS — handles toggle, auth modal, and toast notifications
 */
(function () {
    'use strict';

    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content;
    let pendingProductId = null; // Stores product ID when guest tries to wishlist

    /**
     * Toggle wishlist for a product.
     * If guest → open auth modal instead.
     */
    window.toggleWishlist = function (productId, btnEl, event) {
        // Prevent click from bubbling to parent <a> or other elements
        if (event) {
            event.stopPropagation();
            event.preventDefault();
        }

        // Check if user is authenticated (meta tag set in master.blade.php)
        const isGuest = document.querySelector('meta[name="user-authenticated"]')?.content !== '1';

        if (isGuest) {
            pendingProductId = productId;
            const modal = new bootstrap.Modal(document.getElementById('authModal'));
            modal.show();
            return;
        }

        // Optimistic UI — toggle immediately
        const icon = btnEl.querySelector('i') || btnEl.querySelector('img');
        const isFA = icon && icon.tagName === 'I';
        if (isFA) {
            icon.classList.toggle('fa-solid');
            icon.classList.toggle('fa-regular');
        }
        icon.classList.toggle('wishlisted');
        btnEl.classList.toggle('active');

        fetch('/wishlist/toggle', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ product_id: productId }),
        })
            .then(r => {
                if (r.status === 401 || r.status === 419) {
                    window.location.reload();
                    throw new Error('Session expired');
                }
                if (!r.ok) throw new Error('Server error: ' + r.status);
                return r.json();
            })
            .then(data => {
                if (data.success) {
                    showWishlistToast(data.message);
                    updateWishlistCounts(data.count);
                    syncWishlistButtons(productId, data.added);
                } else {
                    // Revert on failure
                    if (isFA) {
                        icon.classList.toggle('fa-solid');
                        icon.classList.toggle('fa-regular');
                    }
                    icon.classList.toggle('wishlisted');
                    btnEl.classList.toggle('active');
                    showWishlistToast(data.message || 'Something went wrong', 'error');
                }
            })
            .catch((err) => {
                if (err.message !== 'Session expired') {
                    if (isFA) {
                        icon.classList.toggle('fa-solid');
                        icon.classList.toggle('fa-regular');
                    }
                    icon.classList.toggle('wishlisted');
                    btnEl.classList.toggle('active');
                    showWishlistToast('Could not update wishlist. Please try again.', 'error');
                }
            });
    };

    /**
     * Sync all wishlist buttons for the same product ID on the page.
     */
    function syncWishlistButtons(productId, added) {
        document.querySelectorAll(`[data-wishlist-product="${productId}"]`).forEach(btn => {
            const faIcon = btn.querySelector('i');
            const imgIcon = btn.querySelector('img');
            const label = btn.querySelector('span');
            if (added) {
                if (faIcon) {
                    faIcon.classList.remove('fa-regular');
                    faIcon.classList.add('fa-solid', 'wishlisted');
                }
                if (imgIcon) imgIcon.classList.add('wishlisted');
                btn.classList.add('active');
                if (label) label.textContent = 'Remove from Wishlist';
            } else {
                if (faIcon) {
                    faIcon.classList.remove('fa-solid', 'wishlisted');
                    faIcon.classList.add('fa-regular');
                }
                if (imgIcon) imgIcon.classList.remove('wishlisted');
                btn.classList.remove('active');
                if (label) label.textContent = 'Add to Wishlist';
            }
        });
    }

    /**
     * Update all wishlist count badges on the page.
     */
    function updateWishlistCounts(count) {
        document.querySelectorAll('.wishlist-count').forEach(el => {
            el.textContent = count;
        });
    }

    /**
     * Show a toast notification.
     */
    function showWishlistToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast-notification ${type}`;
        toast.innerHTML = `
            <div class="toast-content">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                <span>${message}</span>
            </div>
        `;
        document.body.appendChild(toast);
        toast.offsetHeight; // force reflow
        toast.classList.add('show');
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    /**
     * Auth Modal — Login form handler
     */
    document.addEventListener('DOMContentLoaded', function () {
        const loginForm = document.getElementById('authModalLoginForm');
        const registerForm = document.getElementById('authModalRegisterForm');

        if (loginForm) {
            loginForm.addEventListener('submit', function (e) {
                e.preventDefault();
                clearErrors(loginForm);
                const btn = loginForm.querySelector('button[type="submit"]');
                const originalText = btn.innerHTML;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Logging in...';
                btn.disabled = true;

                fetch('/ajax/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        email: loginForm.querySelector('[name="email"]').value,
                        password: loginForm.querySelector('[name="password"]').value,
                        remember: loginForm.querySelector('[name="remember"]')?.checked || false,
                    }),
                })
                    .then(r => r.json().then(data => ({ status: r.status, data })))
                    .then(({ status, data }) => {
                        if (data.success) {
                            onAuthSuccess(data);
                        } else {
                            showFormErrors(loginForm, data.errors);
                        }
                    })
                    .catch(() => showWishlistToast('Something went wrong', 'error'))
                    .finally(() => {
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    });
            });
        }

        if (registerForm) {
            registerForm.addEventListener('submit', function (e) {
                e.preventDefault();
                clearErrors(registerForm);
                const btn = registerForm.querySelector('button[type="submit"]');
                const originalText = btn.innerHTML;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Creating account...';
                btn.disabled = true;

                fetch('/ajax/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        name: registerForm.querySelector('[name="name"]').value,
                        email: registerForm.querySelector('[name="email"]').value,
                        phone: registerForm.querySelector('[name="phone"]').value,
                        password: registerForm.querySelector('[name="password"]').value,
                        password_confirmation: registerForm.querySelector('[name="password_confirmation"]').value,
                    }),
                })
                    .then(r => r.json().then(data => ({ status: r.status, data })))
                    .then(({ status, data }) => {
                        if (data.success) {
                            onAuthSuccess(data);
                        } else {
                            showFormErrors(registerForm, data.errors);
                        }
                    })
                    .catch(() => showWishlistToast('Something went wrong', 'error'))
                    .finally(() => {
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    });
            });
        }
    });

    /**
     * On successful login/register from modal.
     */
    function onAuthSuccess(data) {
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('authModal'));
        if (modal) modal.hide();

        // Update auth meta tag
        let authMeta = document.querySelector('meta[name="user-authenticated"]');
        if (authMeta) authMeta.content = '1';

        // Update wishlist counts
        updateWishlistCounts(data.wishlist_count || 0);

        showWishlistToast(data.message);

        // If there was a pending wishlist action, execute it
        if (pendingProductId) {
            const btn = document.querySelector(`[data-wishlist-product="${pendingProductId}"]`);
            if (btn) {
                toggleWishlist(pendingProductId, btn);
            }
            pendingProductId = null;
        }
    }

    /**
     * Show form validation errors.
     */
    function showFormErrors(form, errors) {
        if (!errors) return;
        Object.entries(errors).forEach(([field, messages]) => {
            const input = form.querySelector(`[name="${field}"]`);
            if (input) {
                input.classList.add('is-invalid');
                const feedback = input.parentElement.querySelector('.invalid-feedback')
                    || document.createElement('div');
                feedback.className = 'invalid-feedback';
                feedback.textContent = messages[0];
                if (!input.parentElement.querySelector('.invalid-feedback')) {
                    input.parentElement.appendChild(feedback);
                }
            }
        });
    }

    function clearErrors(form) {
        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
    }
})();
