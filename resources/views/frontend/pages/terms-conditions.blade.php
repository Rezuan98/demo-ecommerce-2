@extends('frontend.master.master')

@section('keyTitle', 'Terms & Conditions')

@section('contents')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4 header-text">Terms & Conditions</h2>

                    <p class="text-muted text-center normal-text"><strong>Effective Date:</strong> {{ date('F d, Y') }}</p>

                    <hr>

                    <h4 class="text-primary header-text">1. Introduction</h4>
                    <p class="normal-text">Welcome to <strong>Tazinic!</strong> These Terms and Conditions ("T&C") govern your use of our website,
                        <a href="{{ url('/') }}" class="text-decoration-none">{{ url('/') }}</a>, and the purchase of products from our online store.</p>

                    <h4 class="text-primary mt-4 header-text">2. Acceptance of Terms</h4>
                    <p class="normal-text">By accessing or using our website, you agree to be bound by these T&C. If you are under 18,
                        you must have parental or guardian consent to use our services and make purchases.</p>

                    <h4 class="text-primary mt-4 header-text">3. Use of the Website</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item normal-text">You may use this website only for lawful purposes and in accordance with these terms.</li>
                        <li class="list-group-item normal-text">Prohibited activities include fraud, hacking, spamming, or disrupting our services.</li>
                        <li class="list-group-item normal-text">Users must be at least 18 years old or have parental permission to make purchases.</li>
                        <li class="list-group-item normal-text">You are responsible for maintaining the confidentiality of your account information.</li>
                    </ul>

                    <h4 class="text-primary mt-4 header-text">4. Product Information</h4>
                    <p class="normal-text">We make every effort to display accurate product descriptions, pricing, and availability. However, we do not guarantee
                        that all product descriptions or other content on the site are 100% error-free. Product colors may vary due to screen differences.
                        We reserve the right to correct any errors, inaccuracies, or omissions at any time without prior notice.</p>

                    <h4 class="text-primary mt-4 header-text">5. Ordering and Payment</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item normal-text"><strong>Order Placement:</strong> Orders can be placed online through our secure checkout system.</li>
                        <li class="list-group-item normal-text"><strong>Payment Methods:</strong> We accept Cash on Delivery (COD) and other payment methods as displayed at checkout.</li>
                        <li class="list-group-item normal-text"><strong>Pricing:</strong> All prices are listed in Bangladeshi Taka (BDT) and are subject to change without prior notice.</li>
                        <li class="list-group-item normal-text"><strong>Order Cancellation:</strong> Tazinic reserves the right to cancel any order due to pricing errors, stock issues, or fraudulent activity.</li>
                        <li class="list-group-item normal-text"><strong>Confirmation:</strong> Order confirmation will be sent via email once your order is successfully placed.</li>
                    </ul>

                    <h4 class="text-primary mt-4 header-text">6. Shipping and Delivery</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item normal-text"><strong>Service Area:</strong> We offer delivery services within Bangladesh with different charges for inside and outside Dhaka.</li>
                        <li class="list-group-item normal-text"><strong>Shipping Costs:</strong> Shipping costs and estimated delivery times are displayed at checkout.</li>
                        <li class="list-group-item normal-text"><strong>Delivery Timeline:</strong> Estimated delivery times are provided but not guaranteed due to external factors.</li>
                        <li class="list-group-item normal-text"><strong>External Delays:</strong> We are not responsible for delays caused by shipping carriers, weather conditions, or other circumstances beyond our control.</li>
                        <li class="list-group-item normal-text"><strong>Customer Responsibility:</strong> Customers are responsible for providing accurate delivery information.</li>
                    </ul>

                    <h4 class="text-primary mt-4 header-text">7. Returns and Exchanges</h4>
                    <p class="normal-text">Returns and exchanges are accepted within <strong>7 days</strong> of delivery for eligible items.</p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item normal-text"><strong>Item Condition:</strong> Returned items must be unused, in original condition, and in original packaging.</li>
                        <li class="list-group-item normal-text"><strong>Proof Required:</strong> Proof of purchase (receipt or order confirmation) is required for all returns.</li>
                        <li class="list-group-item normal-text"><strong>Return Shipping:</strong> Customers are responsible for return shipping costs unless the return is due to an error on our part.</li>
                        <li class="list-group-item normal-text"><strong>Refund Processing:</strong> Refunds will be processed within 5-7 business days after we receive the returned item.</li>
                        <li class="list-group-item normal-text"><strong>Non-returnable Items:</strong> Certain items such as undergarments, customized products, or items marked as "Final Sale" are not eligible for return.</li>
                    </ul>

                    <h4 class="text-primary mt-4 header-text">8. Intellectual Property</h4>
                    <p class="normal-text">All website content, including text, images, logos, graphics, and software, is owned by Tazinic or its licensors.
                        Unauthorized reproduction, modification, distribution, or commercial use of our content is strictly prohibited and may result in legal action.</p>

                    <h4 class="text-primary mt-4 header-text">9. User Accounts</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item normal-text"><strong>Account Information:</strong> You are responsible for maintaining accurate account information.</li>
                        <li class="list-group-item normal-text"><strong>Password Security:</strong> You must keep your password secure and not share it with others.</li>
                        <li class="list-group-item normal-text"><strong>Account Activity:</strong> You are responsible for all activities that occur under your account.</li>
                        <li class="list-group-item normal-text"><strong>Account Suspension:</strong> We reserve the right to suspend or terminate accounts that violate these terms.</li>
                    </ul>

                    <h4 class="text-primary mt-4 header-text">10. Limitation of Liability</h4>
                    <p class="normal-text">Tazinic is not liable for any indirect, incidental, special, consequential, or punitive damages arising from the use of our website or products.
                        Our total liability for any claim shall not exceed the amount paid for the specific product giving rise to the claim.</p>

                    <h4 class="text-primary mt-4 header-text">11. Privacy Policy</h4>
                    <p class="normal-text">For information on how we collect, use, and protect your personal data, please refer to our
                        <a href="{{ route('privacy.policy') }}" class="text-decoration-none">Privacy Policy</a>.
                        By using our website, you consent to our privacy practices as described in our Privacy Policy.</p>

                    <h4 class="text-primary mt-4 header-text">12. Governing Law</h4>
                    <p class="normal-text">These Terms and Conditions are governed by the laws of Bangladesh. Any disputes arising from these terms or your use of our website
                        will be resolved in the courts of Dhaka, Bangladesh.</p>

                    <h4 class="text-primary mt-4 header-text">13. Force Majeure</h4>
                    <p class="normal-text">Tazinic shall not be liable for any failure or delay in performance due to circumstances beyond our reasonable control, including but not limited to
                        natural disasters, government actions, strikes, or technical failures.</p>

                    <h4 class="text-primary mt-4 header-text">14. Changes to Terms</h4>
                    <p class="normal-text">We reserve the right to modify these terms at any time without prior notice. Changes will be posted on this page with an updated effective date.
                        Your continued use of our website after changes are posted constitutes acceptance of the updated terms.</p>

                    <h4 class="text-primary mt-4 header-text">15. Severability</h4>
                    <p class="normal-text">If any provision of these terms is found to be invalid or unenforceable, the remaining provisions will continue to be valid and enforceable.</p>

                    <h4 class="text-primary mt-4 header-text">16. Contact Information</h4>
                    <p class="normal-text">If you have any questions regarding these Terms & Conditions, please contact us at:</p>
                    <div class="bg-light p-3 rounded">
                        <p class="mb-1 normal-text"><strong>Email:</strong> <a href="mailto:{{ $settings->email }}" class="text-decoration-none">{{ $settings->email }}</a></p>
                        <p class="mb-1 normal-text"><strong> Phone:</strong> <a href="tel:{{ $settings->phone }}" class="text-decoration-none">{{ $settings->phone }}</a></p>
                        <p class="mb-0 normal-text"><strong> Address:</strong> {{ $settings->address }}</p>
                    </div>

                    <div class="text-center mt-5">
                        <p class="text-muted normal-text"><em>Thank you for choosing Tazinic. We appreciate your business!</em></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('ecomcss')
<style>
.header-text { font-family: "Conthic", sans-serif; color:var(--primary-color)!important; }
.normal-text { font-family: "AloveraDisplay", sans-serif; }
</style>
@endpush