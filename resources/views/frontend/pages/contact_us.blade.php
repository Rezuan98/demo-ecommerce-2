@extends('frontend.master.master')
@section('keyTitle','Contact Us')

@push('ecomcss')
<style>
.contact-page { background: #f5f6f8; padding: 40px 0; }
.card-neutral { background: #ffffff; border: 1px solid #e9ecef; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.04); }
.section-title { font-weight: 700; color: #212529; margin-bottom: 1rem; padding: 30px; }
.section-subtitle { color: #6c757d; margin-bottom: 1.5rem; }
.btn-neutral { background: var(--primary-color); border-color: var(--primary-color); color: #ffffff; transition: transform .2s ease, box-shadow .2s ease, opacity .2s ease; }
.btn-neutral:hover { background: var(--primary-color) border-color: var(--primary-color); transform: translateY(-1px); box-shadow: 0 6px 16px rgba(154, 0, 0, 0.3); color: #ffffff; }
.form-control, .form-select, .form-floating > .form-control { border-color: #dde1e6; }
.form-control:focus { border-color: var(--primary-color); box-shadow: 0 0 0 0.2rem rgba(154, 0, 0, 0.15); }
.form-floating > label { color: #6c757d; }
.map-wrapper { height: 100%; min-height: 520px; overflow: hidden; }
.map-wrapper iframe { border-radius: 10px; }
.map-card { min-height: clamp(360px, 55vh, 640px); display: flex; flex-direction: column; }
.map-frame { flex: 1 1 auto; width: 100%; height: 100%; border: 0; border-radius: 10px; }
.header-text { font-family: "Conthic", sans-serif; color: var(--primary-color)!important; }
.normal-text { font-family: "AloveraDisplay", sans-serif; }
@media (max-width: 991px) { .map-wrapper { min-height: 360px; } }
</style>
@endpush

@push('ecomjs')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    const submitBtn = document.getElementById('submitBtn');
    const buttonText = submitBtn.querySelector('.button-text');
    const spinner = submitBtn.querySelector('.spinner-border');
    const toast = new bootstrap.Toast(document.getElementById('messageToast'));

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        submitBtn.disabled = true;
        buttonText.textContent = 'Sending...';
        spinner.classList.remove('d-none');

        try {
            const formData = new FormData(form);
            const response = await fetch('/messages', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData,
                credentials: 'same-origin'
            });

            const data = await response.json();

            const toastElement = document.querySelector('.toast-body');
            const toastContainer = document.getElementById('messageToast');
            toastContainer.classList.remove('bg-success', 'bg-danger', 'text-white');

            if (data.success) {
                toastElement.textContent = data.message;
                toastContainer.classList.add('bg-success', 'text-white');
                form.reset();
                form.querySelectorAll('.is-valid, .is-invalid').forEach(el => {
                    el.classList.remove('is-valid', 'is-invalid');
                });
            } else {
                toastElement.textContent = data.message || 'Please check your input and try again.';
                toastContainer.classList.add('bg-danger', 'text-white');
            }
            toast.show();

        } catch (error) {
            console.error('Error:', error);
            const toastContainer = document.getElementById('messageToast');
            toastContainer.classList.remove('bg-success', 'bg-danger', 'text-white');
            document.querySelector('.toast-body').innerHTML = 'An error occurred. Please try again.';
            toastContainer.classList.add('bg-danger', 'text-white');
            toast.show();
        } finally {
            submitBtn.disabled = false;
            buttonText.textContent = 'Send Message';
            spinner.classList.add('d-none');
        }
    });

    Array.from(form.elements).forEach(element => {
        element.addEventListener('input', function() {
            if (this.type === 'button' || this.type === 'submit') return;
            if (this.checkValidity()) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            }
        });
    });
});
</script>
@endpush

@section('contents')
<section class="contact-page">
    <div class="container">
        <div class="row g-4 align-items-stretch">
            <div class="col-lg-7">
                <div class="card-neutral p-4 p-lg-5 h-100">
                    <h2 class="section-title header-text">Contact Us</h2>
                    <p class="section-subtitle mb-4 normal-text">Send us a message and our team will get back to you shortly.</p>

                    <form id="contactForm" class="needs-validation" novalidate>
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control normal-text" id="name" name="name" placeholder="Your Name" required>
                                    <label for="name" class="normal-text">Your Name</label>
                                    <div class="invalid-feedback normal-text">Please enter your name</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control normal-text" id="email" name="email" placeholder="Your Email" required>
                                    <label for="email" class="normal-text">Your Email</label>
                                    <div class="invalid-feedback normal-text">Please enter a valid email</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="tel" class="form-control normal-text" id="phone" name="phone" placeholder="Your Phone" required>
                                    <label for="phone" class="normal-text">Your Phone</label>
                                    <div class="invalid-feedback normal-text">Please enter your phone number</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control normal-text" id="subject" name="subject" placeholder="Subject" required>
                                    <label for="subject" class="normal-text">Subject</label>
                                    <div class="invalid-feedback normal-text">Please enter a subject</div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control normal-text" id="message" name="message" style="height: 160px" placeholder="Message" required></textarea>
                                    <label for="message" class="normal-text">Message</label>
                                    <div class="invalid-feedback normal-text">Please enter your message</div>
                                </div>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-neutral px-5 py-3 rounded-pill normal-text" id="submitBtn">
                                    <span class="button-text">Send Message</span>
                                    <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card-neutral p-3 map-card">
                    <iframe
                        class="map-frame"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d58393.91445465884!2d90.3193534919322!3d23.83212042511309!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c124b21679e3%3A0x48d7e114b00a18cb!2sPallabi%2C%20Dhaka!5e0!3m2!1sen!2sbd!4v1757555825128!5m2!1sen!2sbd"
                        allowfullscreen
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>

        </div>
    </div>
</section>

<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
    <div id="messageToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto normal-text">chileghuri</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body normal-text"></div>
    </div>
</div>
@endsection