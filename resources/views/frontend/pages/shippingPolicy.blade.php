@extends('frontend.master.master')

@section('keyTitle', 'Shipping Policy')

@section('contents')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4 header-text">Shipping Policy</h2>

                    <p class="text-muted text-center normal-text"><strong>Last Updated:</strong> {{ date('F d, Y') }}</p>

                    <hr>

                    <h4 class="text-primary header-text">1. Domestic Shipping</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item normal-text"><strong>Service Area:</strong> We offer home delivery services throughout Bangladesh.</li>
                        <li class="list-group-item normal-text"><strong>Processing Time:</strong> Orders are processed within 1-2 business days after payment confirmation.</li>
                        <li class="list-group-item normal-text"><strong>Delivery Time:</strong> Standard delivery takes 3-5 business days, depending on the destination within Bangladesh.</li>
                        <li class="list-group-item normal-text"><strong>Shipping Charges:</strong> Shipping fees are calculated at checkout based on the delivery location and order weight.</li>
                    </ul>

                    <h4 class="text-primary mt-4 header-text">2. International Shipping</h4>
                    <p class="normal-text normal-text ">Currently, we <strong>do not offer</strong> international shipping.</p>

                    <h4 class="text-primary mt-4 header-text">3. Order Tracking</h4>
                    <p>Once your order is shipped, you will receive a confirmation email with tracking information. You can also track your order status by logging into your account on our website.</p>

                    <h4 class="text-primary mt-4 header-text">4. Shipping Promotions</h4>
                    <p>During promotional periods, such as our <strong>New Year Mega Sale</strong>, enjoy exclusive discounts across all categories, plus <strong>free shipping</strong> on orders over <strong>a specific amountgit</strong>.</p>

                    <h4 class="text-primary mt-4 header-text">5. Delivery Issues</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item normal-text"><strong>Incorrect Address:</strong> Please ensure that your shipping address is correct. We are not responsible for orders delivered to incorrect or incomplete addresses provided by the customer.</li>
                        <li class="list-group-item normal-text"><strong>Lost or Damaged Packages:</strong> If your package is lost or arrives damaged, please contact us immediately at <a href="mailto:{{ $settings->email }}" class="text-decoration-none">{{ $settings->email }}</a> or call <a href="tel:{{ $settings->phone }}" class="text-decoration-none">+8801811384324</a>.</li>
                    </ul>

                    <h4 class="text-primary mt-4 header-text">6. Contact Information</h4>
                    <div class="bg-light p-3 rounded">
                        <p class="mb-1 normal-text"><strong> Email:</strong> <a href="mailto:{{ $settings->email }}" class="text-decoration-none">{{ $settings->email }}</a></p>
                        <p class="mb-1 normal-text"><strong> Phone:</strong> <a href="tel:{{ $settings->phone }}" class="text-decoration-none">{{ $settings->phone }}</a></p>
                        <p class="mb-0 normal-text"><strong> Address:</strong> {{ $settings->address }}</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('ecomcss')
    <style>
.header-text { font-family: "Conthic", sans-serif;color: var(--primary-color)!important;}

.normal-text {font-family:"AloveraDisplay",sans-serif;}
        </style>
@endpush