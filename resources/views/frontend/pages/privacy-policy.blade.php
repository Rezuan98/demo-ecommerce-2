@extends('frontend.master.master')

@section('keyTitle', 'Privacy Policy')

@section('contents')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4 header-text">Privacy Policy</h2>

                    <p class="text-muted text-center normal-text"><strong>Last Updated:</strong> {{ date('F d, Y') }}</p>

                    <hr>

                    <h4 class="text-primary header-text">1. Introduction</h4>
                    <p class="normal-text">Welcome to <strong>chileghuri</strong> ("we," "us," or "our"). This Privacy Policy explains how we collect, use, disclose, and protect your personal information when you visit our website, <a href="{{ url('/') }}" class="text-decoration-none">{{ url('/') }}</a>, and use our services. By using our website, you agree to the collection and use of information in accordance with this policy.</p>

                    <h4 class="text-primary mt-4 header-text">2. Information We Collect</h4>
                    <h5 class="text-secondary header-text">2.1 Personal Information</h5>
                    <p class="normal-text">When you interact with our website, we may collect the following personal information:</p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item normal-text"><strong>Account Information:</strong> Name, email address, phone number, and password when you create an account.</li>
                        <li class="list-group-item normal-text"><strong>Order Information:</strong> Billing and shipping addresses, payment information, and order history.</li>
                        <li class="list-group-item normal-text"><strong>Contact Information:</strong> Information you provide when contacting our customer service or subscribing to newsletters.</li>
                        <li class="list-group-item normal-text"><strong>Profile Information:</strong> Any additional information you choose to provide in your user profile.</li>
                    </ul>

                    <h5 class="text-secondary mt-3 header-text">2.2 Non-Personal Information</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item normal-text"><strong>Technical Information:</strong> Browser type, device information, IP address, operating system, and referring website.</li>
                        <li class="list-group-item normal-text"><strong>Usage Information:</strong> Pages visited, time spent on our website, search terms, and interaction with our content.</li>
                        <li class="list-group-item normal-text"><strong>Cookies and Tracking:</strong> We use cookies and similar technologies to enhance user experience and analyze website performance.</li>
                    </ul>

                    <h4 class="text-primary mt-4 header-text">3. How We Use Your Information</h4>
                    <p class="normal-text">We use your information for the following purposes:</p>
                    <ul>
                        <li class="normal-text"><strong>Order Processing:</strong> To process and fulfill your orders, send confirmations, and provide customer support.</li>
                        <li class="normal-text"><strong>Account Management:</strong> To create and manage your user account and provide personalized services.</li>
                        <li class="normal-text"><strong>Communication:</strong> To respond to your inquiries, send important updates, and provide customer service.</li>
                        <li class="normal-text"><strong>Marketing:</strong> To send promotional emails, newsletters, and special offers (you can opt-out at any time).</li>
                        <li class="normal-text"><strong>Website Improvement:</strong> To analyze website usage, improve our services, and enhance user experience.</li>
                        <li class="normal-text"><strong>Security:</strong> To detect, prevent, and address fraud, security issues, and technical problems.</li>
                        <li class="normal-text"><strong>Legal Compliance:</strong> To comply with applicable laws, regulations, and legal processes.</li>
                    </ul>

                    <h4 class="text-primary mt-4 header-text">4. Sharing of Information</h4>
                    <p class="normal-text">We do not sell, trade, or rent your personal information to third parties. However, we may share your information in the following circumstances:</p>
                    <ul>
                        <li class="normal-text"><strong>Service Providers:</strong> With trusted third-party service providers who assist us in operating our website, processing payments (Cash on Delivery services, mobile banking), shipping orders, and providing customer support.</li>
                        <li class="normal-text"><strong>Business Transfers:</strong> In connection with any merger, sale of company assets, financing, or acquisition of all or a portion of our business.</li>
                        <li class="normal-text"><strong>Legal Requirements:</strong> When required by law, court order, or to protect our rights, property, or safety, or that of our users or others.</li>
                        <li class="normal-text"><strong>Consent:</strong> With your explicit consent for any other purpose not described in this policy.</li>
                    </ul>

                    <h4 class="text-primary mt-4 header-text">5. Data Security</h4>
                    <p class="normal-text">We implement appropriate technical and organizational measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction. These measures include:</p>
                    <ul>
                        <li class="normal-text">SSL encryption for data transmission</li>
                        <li class="normal-text">Secure servers and databases</li>
                        <li class="normal-text">Regular security assessments</li>
                        <li class="normal-text">Access controls and authentication procedures</li>
                    </ul>
                    <p class="normal-text">However, please note that no method of transmission over the internet or electronic storage is 100% secure, and we cannot guarantee absolute security.</p>

                    <h4 class="text-primary mt-4 header-text">6. Your Rights and Choices</h4>
                    <p class="normal-text">You have the following rights regarding your personal information:</p>
                    <ul>
                        <li class="normal-text"><strong>Access:</strong> Request access to your personal information that we hold.</li>
                        <li class="normal-text"><strong>Correction:</strong> Request correction of inaccurate or incomplete personal information.</li>
                        <li class="normal-text"><strong>Deletion:</strong> Request deletion of your personal information, subject to certain legal limitations.</li>
                        <li class="normal-text"><strong>Opt-out:</strong> Unsubscribe from marketing communications at any time.</li>
                        <li class="normal-text"><strong>Data Portability:</strong> Request a copy of your personal information in a portable format.</li>
                        <li class="normal-text"><strong>Withdraw Consent:</strong> Withdraw your consent for data processing where we rely on consent.</li>
                    </ul>
                    <p class="normal-text">To exercise any of these rights, please contact us at <a href="mailto:{{ $settings->email }}" class="text-decoration-none">{{ $settings->email }}</a>.</p>

                    <h4 class="text-primary mt-4 header-text">7. Cookies and Tracking Technologies</h4>
                    <p class="normal-text">We use cookies and similar tracking technologies to:</p>
                    <ul>
                        <li class="normal-text">Remember your preferences and settings</li>
                        <li class="normal-text">Keep you logged in to your account</li>
                        <li class="normal-text">Analyze website traffic and user behavior</li>
                        <li class="normal-text">Provide personalized content and advertisements</li>
                        <li class="normal-text">Improve website functionality and performance</li>
                    </ul>
                    <p class="normal-text">You can manage your cookie preferences through your browser settings. However, disabling cookies may affect some website functionality.</p>

                    <h4 class="text-primary mt-4 header-text">8. Children's Privacy</h4>
                    <p class="normal-text">Our website is not intended for children under the age of 13. We do not knowingly collect personal information from children under 13. If you are a parent or guardian and believe that your child has provided us with personal information, please contact us, and we will delete such information from our records.</p>

                    <h4 class="text-primary mt-4 header-text">9. Third-Party Links and Services</h4>
                    <p class="normal-text">Our website may contain links to third-party websites, social media platforms, or services that are not operated by us. We are not responsible for the privacy practices of these third parties. We encourage you to review the privacy policies of any third-party websites you visit.</p>

                    <h4 class="text-primary mt-4 header-text">10. Data Retention</h4>
                    <p class="normal-text">We retain your personal information for as long as necessary to fulfill the purposes outlined in this Privacy Policy, unless a longer retention period is required or permitted by law. When we no longer need your personal information, we will securely delete or anonymize it.</p>

                    <h4 class="text-primary mt-4 header-text">11. International Data Transfers</h4>
                    <p class="normal-text">Your information may be transferred to and processed in countries other than your country of residence. We ensure that such transfers comply with applicable data protection laws and implement appropriate safeguards to protect your information.</p>

                    <h4 class="text-primary mt-4 header-text">12. Changes to This Privacy Policy</h4>
                    <p class="normal-text">We may update this Privacy Policy from time to time to reflect changes in our practices, technology, legal requirements, or other factors. We will notify you of any material changes by posting the updated policy on our website with a revised "Last Updated" date. Your continued use of our website after such changes constitutes acceptance of the updated policy.</p>

                    <h4 class="text-primary mt-4 header-text">13. Contact Information</h4>
                    <p class="normal-text">If you have any questions, concerns, or requests regarding this Privacy Policy or our data practices, please contact us:</p>
                    <div class="bg-light p-3 rounded">
                        <p class="mb-1 normal-text"><strong> Email:</strong> <a href="mailto:{{ $settings->email }}" class="text-decoration-none">{{ $settings->email }}</a></p>
                        <p class="mb-1 normal-text"><strong>Phone:</strong> <a href="tel:{{ $settings->phone }}" class="text-decoration-none">{{ $settings->phone }}</a></p>
                        <p class="mb-0 normal-text"><strong> Address:</strong> {{ $settings->address }}</p>
                    </div>

                    <div class="text-center mt-5">
                        <p class="text-muted normal-text"><em>Your privacy is important to us. Thank you for trusting chileghuri with your personal information.</em></p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('ecomcss')
<style>
.header-text { font-family: "Conthic", sans-serif; color: var(--primary-color)!important; }
.normal-text { font-family: "AloveraDisplay", sans-serif; }
</style>
@endpush