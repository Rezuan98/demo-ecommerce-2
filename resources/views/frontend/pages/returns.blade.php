@extends('frontend.master.master')

@section('keyTitle', 'Returns & Exchanges Policy')

@section('contents')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4 header-text">Returns & Exchanges Policy</h2>

                    <p class="text-muted text-center normal-text"><strong>Last Updated:</strong> {{ date('F d, Y') }}</p>

                    <hr>

                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        <span class="normal-text"><strong>Customer Satisfaction:</strong> At chileghuri, your satisfaction is our priority. We want you to be completely happy with your purchase.</span>
                    </div>

                    <h4 class="text-primary header-text">1. Return Eligibility</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item normal-text"><strong>Time Frame:</strong> Customers may return items within <strong>7 days</strong> from the date of delivery for eligible products.</li>
                        <li class="list-group-item normal-text"><strong>Condition Requirements:</strong> Items must be <strong>unused, unworn, unwashed</strong>, and in their original condition with all tags, labels, and packaging intact.</li>
                        <li class="list-group-item normal-text"><strong>Proof of Purchase:</strong> Original receipt, order confirmation, or invoice is required for all returns and exchanges.</li>
                        <li class="list-group-item normal-text"><strong>Non-Returnable Items:</strong> 
                            <ul class="mt-2">
                                <li class="normal-text">Intimate apparel and undergarments</li>
                                <li class="normal-text">Custom-made or personalized items</li>
                                <li class="normal-text">Items marked as "Final Sale" or "Clearance"</li>
                                <li class="normal-text">Products that have been worn, used, or damaged by the customer</li>
                                <li class="normal-text">Items without original tags or packaging</li>
                            </ul>
                        </li>
                    </ul>

                    <h4 class="text-primary mt-4 header-text">2. Return Process</h4>
                    <h5 class="text-secondary header-text">Step-by-Step Guide:</h5>
                    <ol class="list-group list-group-numbered">
                        <li class="list-group-item normal-text"><strong>Contact Us:</strong> Contact our Customer Service team at <a href="mailto:{{ $settings->email }}" class="text-decoration-none">{{ $settings->email }}</a> or call <a href="tel:{{ $settings->phone }}" class="text-decoration-none">{{ $settings->phone }}</a>. Provide your order number and reason for return.</li>
                        <li class="list-group-item normal-text"><strong>Return Authorization:</strong> Our team will provide you with return instructions and authorization if your return qualifies.</li>
                        <li class="list-group-item normal-text"><strong>Package Items:</strong> Carefully package the item(s) in original packaging with all tags and accessories included.</li>
                        <li class="list-group-item normal-text"><strong>Shipping:</strong> Ship the package to our return address (provided by customer service). Customers are responsible for return shipping costs unless the return is due to our error.</li>
                        <li class="list-group-item normal-text"><strong>Inspection:</strong> Upon receipt, returned items will be inspected within 2-3 business days. If the item doesn't meet return criteria, it will be sent back to the customer.</li>
                    </ol>

                    <h4 class="text-primary mt-4 header-text">3. Refunds</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item normal-text"><strong>Processing Time:</strong> Refunds will be processed within <strong>5-7 business days</strong> after we receive and approve the returned item.</li>
                        <li class="list-group-item normal-text"><strong>Refund Method:</strong> 
                            <ul class="mt-2">
                                <li class="normal-text">Cash on Delivery (COD) orders: Refund via bank transfer or mobile banking</li>
                                <li class="normal-text">Online payments: Refund to original payment method</li>
                                <li class="normal-text">Mobile banking: Refund to the same mobile banking account</li>
                            </ul>
                        </li>
                        <li class="list-group-item normal-text"><strong>Refund Amount:</strong> The product price will be refunded. Original shipping charges are <strong>non-refundable</strong> unless the return is due to our error.</li>
                        <li class="list-group-item normal-text"><strong>Partial Refunds:</strong> May be issued for items that are returned in less than perfect condition but still acceptable for return.</li>
                    </ul>

                    <h4 class="text-primary mt-4 header-text">4. Exchanges</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item normal-text"><strong>Eligibility:</strong> Exchanges are allowed for items of the same or lesser value, subject to stock availability.</li>
                        <li class="list-group-item normal-text"><strong>Size/Color Exchanges:</strong> We accept exchanges for different sizes or colors of the same product within the 7-day return window.</li>
                        <li class="list-group-item normal-text"><strong>Price Difference:</strong> If exchanging for a higher-priced item, you'll need to pay the difference. If exchanging for a lower-priced item, we'll refund the difference.</li>
                        <li class="list-group-item normal-text"><strong>Exchange Process:</strong> Contact Customer Service at <a href="mailto:{{ $settings->email }}" class="text-decoration-none">{{ $settings->email }}</a> or <a href="tel:{{ $settings->phone }}" class="text-decoration-none">{{ $settings->phone }}</a>. If the desired item is unavailable, a refund will be processed instead.</li>
                        <li class="list-group-item normal-text"><strong>Exchange Shipping:</strong> Customer pays for return shipping; we cover shipping for the replacement item.</li>
                    </ul>

                    <h4 class="text-primary mt-4 header-text">5. Damaged or Defective Items</h4>
                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <span class="normal-text"><strong>Quality Guarantee:</strong> We stand behind the quality of our products.</span>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item normal-text"><strong>Reporting Time:</strong> Please notify us within <strong>48 hours</strong> of delivery if you receive a damaged or defective item.</li>
                        <li class="list-group-item normal-text"><strong>Documentation:</strong> Provide photos of the damaged item and packaging to help us process your claim quickly.</li>
                        <li class="list-group-item normal-text"><strong>Resolution:</strong> We will arrange for a replacement or full refund, including return shipping costs, at no charge to you.</li>
                        <li class="list-group-item normal-text"><strong>Manufacturing Defects:</strong> Items with manufacturing defects will be replaced or refunded regardless of the return time frame.</li>
                    </ul>

                    <h4 class="text-primary mt-4 header-text">6. Wrong Item Received</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item normal-text"><strong>Our Error:</strong> If we send you the wrong item, we'll cover all return shipping costs and send the correct item immediately.</li>
                        <li class="list-group-item normal-text"><strong>Quick Resolution:</strong> Contact us immediately, and we'll arrange for pickup and replacement of the incorrect item.</li>
                    </ul>

                    <h4 class="text-primary mt-4 header-text">7. Delivery Area Coverage</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item normal-text"><strong>Bangladesh-wide:</strong> We accept returns from all areas where we deliver within Bangladesh.</li>
                        <li class="list-group-item normal-text"><strong>Return Address:</strong> Our customer service team will provide the appropriate return address based on your location.</li>
                        <li class="list-group-item normal-text"><strong>Pickup Service:</strong> In Dhaka area, we may offer pickup service for returns (charges may apply).</li>
                    </ul>

                    <h4 class="text-primary mt-4 header-text">8. Special Circumstances</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item normal-text"><strong>Holiday Purchases:</strong> Items purchased during sale periods or holidays may have extended return periods as announced.</li>
                        <li class="list-group-item normal-text"><strong>Gift Returns:</strong> Gift recipients can return items for store credit or exchange without original payment method.</li>
                        <li class="list-group-item normal-text"><strong>Bulk Orders:</strong> Special return terms may apply for bulk orders - please contact us for details.</li>
                    </ul>

                    <h4 class="text-primary mt-4 header-text">9. Return Tracking</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item normal-text"><strong>Status Updates:</strong> We'll keep you informed about your return status via email or SMS.</li>
                        <li class="list-group-item normal-text"><strong>Return ID:</strong> Each return will be assigned a unique ID for tracking purposes.</li>
                    </ul>

                    <h4 class="text-primary mt-4 header-text">10. Policy Updates</h4>
                    <p class="normal-text">chileghuri reserves the right to modify this Returns and Exchanges Policy at any time. Changes will be posted on our website with an updated "Last Updated" date. It is the customer's responsibility to review the policy periodically. Any changes will apply to purchases made after the effective date of the updated policy.</p>

                    <h4 class="text-primary mt-4 header-text">11. Customer Support</h4>
                    <p class="normal-text">Our customer service team is here to help make your return or exchange process as smooth as possible. Don't hesitate to reach out with any questions or concerns.</p>
                    
                    <div class="bg-light p-3 rounded">
                        <p class="mb-1 normal-text"><strong> Email:</strong> <a href="mailto:{{ $settings->email }}" class="text-decoration-none">{{ $settings->email }}</a></p>
                        <p class="mb-1 normal-text"><strong>Phone:</strong> <a href="tel:{{ $settings->phone }}" class="text-decoration-none">{{ $settings->phone }}</a></p>
                        <p class="mb-1 normal-text"><strong> Address:</strong> {{ $settings->address }}</p>
                        <p class="mb-0 normal-text"><strong> Support Hours:</strong> Saturday to Thursday, 10:00 AM - 6:00 PM (Closed on Fridays)</p>
                    </div>

                    <div class="text-center mt-5">
                        <p class="text-muted normal-text"><em>Thank you for choosing chileghuri. Your satisfaction is our commitment!</em></p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('ecomcss')
<style>
.header-text { font-family: "Conthic", sans-serif; color: #9A0000!important; }
.normal-text { font-family: "AloveraDisplay", sans-serif; }
</style>
@endpush