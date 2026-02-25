<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function contactUs(){

        return view('frontend.pages.contact_us');
    }

    public function aboutUs(){

        return view('frontend.pages.about_us');
    }

    public function faq()
    {
        // You can later load these from DB; for now, simple array.
        $faqs = [
            [
                'q' => 'How do I place an order on Tazinic?',
                'a' => 'Browse products, add to cart, go to checkout, fill in shipping details, and choose your payment method (Cash on Delivery or Online via SSLCommerz).'
            ],
            [
                'q' => 'What payment methods do you accept?',
                'a' => 'We support Cash on Delivery and Online Payments (cards, mobile banking) via SSLCommerz.'
            ],
            [
                'q' => 'How long does delivery take?',
                'a' => 'Inside Dhaka usually 1–3 business days; outside Dhaka 3–5 business days depending on courier routes.'
            ],
            [
                'q' => 'Can I track my order?',
                'a' => 'Yes. After dispatch, we send tracking details via SMS or email. You can also contact support with your order ID.'
            ],
            [
                'q' => 'What is your return/refund policy?',
                'a' => 'If an item is damaged, defective, or wrong, report within 48 hours of delivery. We arrange return/replacement according to our policy.'
            ],
        ];

        return view('frontend.pages.faq', compact('faqs'));
    }

}
