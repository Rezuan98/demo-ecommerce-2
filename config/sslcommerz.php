<?php
return [
    'store_id' => env('SSLCOMMERZ_STORE_ID'),
    'store_password' => env('SSLCOMMERZ_STORE_PASSWORD'),
    'sandbox' => env('SSLCOMMERZ_SANDBOX', true),
    'success_url' => env('APP_URL') . '/payment/success',
    'fail_url' => env('APP_URL') . '/payment/fail',
    'cancel_url' => env('APP_URL') . '/payment/cancel',
    'ipn_url' => env('APP_URL') . '/payment/ipn',
];