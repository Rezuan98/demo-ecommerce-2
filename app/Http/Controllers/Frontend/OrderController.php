<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVarient;
use App\Models\OrderItem;
use App\Models\DeliveryCharge;
use App\Models\Payment;
use App\Models\SiteSetting;
use App\Models\Coupon;
use App\Mail\CustomerOrderConfirmation;
use App\Mail\AdminOrderConfirmation;

class OrderController extends Controller
{
    public function shipping()
    {
        if (Auth::check()) {
            $user = Auth::user();
            // For authenticated users - get cart from database
            $cartItems = Cart::where('user_id', Auth::id())
                ->with('product', 'variant')
                ->get();
        } else {
            $user = null;
            // For guest users - get cart from session
            $cart = session()->get('cart', []);



            // Get cart items from session and format them
            $cartItems = collect($cart)->map(function ($item, $key) {
                return (object) [
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'product_id' => $item['product_id'],
                    'varient_id' => $item['varient_id'],
                    // Get product details
                    'product' => Product::with(['variants'])->find($item['product_id']),
                    // Get variant details
                    'variant' => ProductVarient::with(['size'])->find($item['varient_id'])
                ];
            })->values();
        }

        // Redirect if cart is empty
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty!');
        }

        $deliveryCharge1 = DeliveryCharge::where('status', true)
            ->where('location_type', 'inside_dhaka')
            ->first();

        $deliveryCharge2 = DeliveryCharge::where('status', true)
            ->where('location_type', 'outside_dhaka')
            ->first();

        $deliveryCharge3 = DeliveryCharge::where('status', true)
            ->where('location_type', 'inside_dhaka(urgent)')
            ->first();

        // Get delivery location from session
        $delivery_location = session('delivery_location', 'inside');

        return view('frontend.pages.shipping', compact('user', 'cartItems', 'delivery_location', 'deliveryCharge1', 'deliveryCharge2', 'deliveryCharge3'));
    }




    public function store(Request $request)
    {
        $validationRules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'payment_method' => 'required|in:cod,bkash,sslcommerz',
        ];

        if ($request->payment_method === 'bkash') {
            $validationRules['bkash_mobile'] = 'required|regex:/^01[3-9]\d{8}$/';
            $validationRules['bkash_transaction_id'] = 'required|string|max:20';
        }

        $request->validate($validationRules);

        try {
            DB::beginTransaction();

            // Get cart items (same as your existing code)
            if (Auth::check()) {
                $cartItems = Cart::where('user_id', Auth::id())->with(['product', 'variant'])->get();
            } else {
                $cart = session()->get('cart', []);
                $cartItems = collect($cart)->map(function ($item) {
                    return (object) [
                        'product_id' => $item['product_id'],
                        'varient_id' => $item['varient_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'product' => Product::find($item['product_id']),
                        'variant' => ProductVarient::find($item['varient_id'])
                    ];
                });
            }

            if ($cartItems->isEmpty()) {
                return redirect()->back()->with('error', 'Your cart is empty!');
            }

            $subtotal = $cartItems->sum(function ($item) {
                return $item->price * $item->quantity;
            });

            $shipping = $request->city;

            // Handle coupon discount
            $couponCode = null;
            $discountAmount = 0;
            $couponSession = session()->get('coupon');

            if ($couponSession) {
                $coupon = Coupon::where('code', $couponSession['code'])->first();
                if ($coupon && $coupon->isValid($subtotal)) {
                    $discountAmount = $coupon->calculateDiscount($subtotal);
                    $couponCode = $coupon->code;
                    $coupon->increment('used_count');
                }
                session()->forget('coupon');
            }

            $total = $subtotal - $discountAmount + $shipping;

            // Create order
            $order = new Order();
            $order->order_number = $this->generateOrderNumber();
            $order->user_id = Auth::check() ? Auth::id() : null;
            $order->session_id = !Auth::check() ? uniqid('guest_', true) : null;
            $order->subtotal = $subtotal;
            $order->shipping_charge = $shipping;
            $order->tax = 0;
            $order->coupon_code = $couponCode;
            $order->discount_amount = $discountAmount;
            $order->total = $total;
            $order->payment_method = $request->payment_method;
            $order->payment_status = 'pending';
            $order->order_status = 'pending';
            $order->name = $request->name;
            $order->email = $request->email;
            $order->phone = $request->phone;
            $order->address = $request->address;
            $order->city = $request->city;
            $order->order_notes = $request->order_notes;

            if ($request->payment_method === 'bkash') {
                $order->bkash_mobile = $request->bkash_mobile;
                $order->bkash_transaction_id = $request->bkash_transaction_id;
            }

            $order->save();

            // Create order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'variant_id' => $item->varient_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->price * $item->quantity,
                    'variant_size' => $item->variant->size->name ?? null
                ]);
            }

            DB::commit();

            // Send order confirmation emails
            $this->sendOrderConfirmationEmails($order);

            // Handle different payment methods
            if ($request->payment_method === 'sslcommerz') {
                return $this->initiateSSLCommerzPayment($order);
            } else {
                // For COD and Bkash - complete order immediately
                $this->completeOrder($order);
                return redirect()->route('order.success', $order->order_number)
                    ->with('success', 'Order placed successfully!');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong! Please try again.');
        }
    }

    private function initiateSSLCommerzPayment($order)
    {
        $postData = [
            'store_id' => config('sslcommerz.store_id'),
            'store_passwd' => config('sslcommerz.store_password'),
            'total_amount' => $order->total,
            'currency' => 'BDT',
            'tran_id' => $order->order_number,
            'success_url' => url('/payment/success'), // Direct URL generation
            'fail_url' => url('/payment/fail'),
            'cancel_url' => url('/payment/cancel'),
            'ipn_url' => url('/payment/ipn'),
            'cus_name' => $order->name,
            'cus_email' => $order->email,
            'cus_add1' => $order->address,
            'cus_city' => 'Dhaka',
            'cus_postcode' => '1000',
            'cus_country' => 'Bangladesh',
            'cus_phone' => $order->phone,
            'ship_name' => $order->name,
            'ship_add1' => $order->address,
            'ship_city' => 'Dhaka',
            'ship_postcode' => '1000',
            'ship_country' => 'Bangladesh',
            'shipping_method' => 'YES',
            'product_name' => 'Order #' . $order->order_number,
            'product_category' => 'General',
            'product_profile' => 'general',
        ];

        $url = config('sslcommerz.sandbox')
            ? 'https://sandbox.sslcommerz.com/gwprocess/v4/api.php'
            : 'https://securepay.sslcommerz.com/gwprocess/v4/api.php';

        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_TIMEOUT, 30);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($handle, CURLOPT_POST, 1);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, true);

        $content = curl_exec($handle);
        $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

        if ($code == 200 && !curl_errno($handle)) {
            curl_close($handle);
            $sslcommerzResponse = json_decode($content, true);

            if (isset($sslcommerzResponse['GatewayPageURL']) && $sslcommerzResponse['GatewayPageURL'] != "") {
                Payment::create([
                    'order_id' => $order->id,
                    'payment_method' => 'sslcommerz',
                    'sslcommerz_session_id' => $sslcommerzResponse['sessionkey'],
                    'amount' => $order->total,
                    'currency' => 'BDT',
                    'status' => 'pending',
                    'gateway_response' => $sslcommerzResponse
                ]);

                return redirect($sslcommerzResponse['GatewayPageURL']);
            } else {
                \Log::error('SSLCommerz Error: No Gateway URL', $sslcommerzResponse);
                return redirect()->route('cart.index')->with('error', 'Payment gateway error. Please try again.');
            }
        } else {
            curl_close($handle);
            \Log::error('SSLCommerz Connection Error', ['code' => $code, 'error' => curl_error($handle)]);
            return redirect()->route('cart.index')->with('error', 'Connection error. Please try again.');
        }
    }

    private function completeOrder($order)
    {
        // Clear cart and update inventory
        DB::transaction(function () use ($order) {
            if (Auth::check()) {
                $cartItems = Cart::where('user_id', Auth::id())->with('variant')->get();
                foreach ($cartItems as $item) {
                    if ($item->variant) {
                        $variant = ProductVarient::lockForUpdate()->find($item->variant->id);
                        if ($variant && $variant->stock_quantity >= $item->quantity) {
                            $variant->decrement('stock_quantity', $item->quantity);
                        }
                    }
                }
                Cart::where('user_id', Auth::id())->delete();
            } else {
                $cart = session()->get('cart', []);
                foreach ($cart as $item) {
                    $variant = ProductVarient::lockForUpdate()->find($item['varient_id']);
                    if ($variant && $variant->stock_quantity >= $item['quantity']) {
                        $variant->decrement('stock_quantity', $item['quantity']);
                    }
                }
                session()->forget(['cart']);
                session()->flash('temp_order_number', $order->order_number);
            }
        });
    }

    /**
     * Send order confirmation emails to customer and admin
     */
    private function sendOrderConfirmationEmails($order)
    {
        try {
            // Load order with relationships for email
            $order->load(['items.product', 'items.variant']);

            // Send email to customer
            Mail::to($order->email)->queue(new CustomerOrderConfirmation($order));

            // Send email to admin
            $siteSetting = SiteSetting::first();
            if ($siteSetting && $siteSetting->email) {
                Mail::to($siteSetting->email)->queue(new AdminOrderConfirmation($order));
            }

            Log::info('Order confirmation emails queued for order: ' . $order->order_number);
        } catch (\Exception $e) {
            // Log error but don't fail the order process
            Log::error('Failed to send order confirmation emails: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'order_number' => $order->order_number
            ]);
        }
    }

    public function success($orderNumber)
    {
        if (!Auth::check() && !session()->has('temp_order_number')) {
            return redirect()->route('home')
                ->with('error', 'Order not found!');
        }

        $order = Order::where('order_number', $orderNumber)
            ->with(['items.product', 'items.variant'])
            ->firstOrFail();

        // Clear temporary order session after showing success page
        session()->forget('temp_order_number');

        return view('frontend.pages.success_order', compact('order'));
    }

    private function generateOrderNumber()
    {
        $prefix = 'ORD';
        $date = now()->format('ymd');
        $uniqueId = strtoupper(substr(uniqid(), -4));
        $timestamp = now()->format('His'); // Add hours, minutes, seconds

        return $prefix . $date . $timestamp . $uniqueId;
    }

    public function show($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with(['items.product', 'items.variant']);

        // Handle authentication check for order viewing
        if (Auth::check()) {
            $order = $order->where('user_id', Auth::id());
        } else {
            // For guest users, check session ID and stored order number
            $order = $order->where('session_id', session()->getId())
                ->where('order_number', session('guest_order'));
        }

        $order = $order->firstOrFail();

        return view('back-kend.order.show', compact('order'));
    }

    public function updatePaymentStatus(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:orders,id',
                'payment_status' => 'required|in:pending,paid,failed'
            ]);

            $order = Order::find($request->id);
            $order->payment_status = $request->payment_status;
            $order->save();

            return response()->json(['success' => true, 'message' => 'Payment status updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update payment status!']);
        }
    }

    /**
     * Show the track order page.
     * Uses demo tracking states based on order_status.
     * Replace with real courier API when available.
     */
    public function trackOrder(Request $request)
    {
        $order = null;
        $trackingSteps = [];
        $searched = false;

        if ($request->has('order_id') && $request->order_id) {
            $searched = true;
            $order = Order::where('order_number', $request->order_id)
                ->with(['items.product'])
                ->first();

            if ($order) {
                // Define all tracking steps with demo timestamps
                $allSteps = [
                    'pending' => [
                        'label' => 'Order Placed',
                        'icon' => 'fa-clipboard-check',
                        'description' => 'Your order has been placed successfully.',
                        'date' => $order->created_at->format('d M Y, h:i A'),
                    ],
                    'processing' => [
                        'label' => 'Processing',
                        'icon' => 'fa-box-open',
                        'description' => 'Your order is being prepared and packed.',
                        'date' => $order->updated_at->format('d M Y, h:i A'),
                    ],
                    'shipped' => [
                        'label' => 'Shipped',
                        'icon' => 'fa-truck',
                        'description' => 'Your order is on the way to you.',
                        'date' => $order->updated_at->format('d M Y, h:i A'),
                    ],
                    'delivered' => [
                        'label' => 'Delivered',
                        'icon' => 'fa-check-circle',
                        'description' => 'Your order has been delivered.',
                        'date' => $order->updated_at->format('d M Y, h:i A'),
                    ],
                ];

                // Handle cancelled status separately
                if ($order->order_status === 'cancelled') {
                    $trackingSteps = [
                        [
                            'label' => 'Order Placed',
                            'icon' => 'fa-clipboard-check',
                            'description' => 'Your order was placed.',
                            'date' => $order->created_at->format('d M Y, h:i A'),
                            'completed' => true,
                            'active' => false,
                        ],
                        [
                            'label' => 'Cancelled',
                            'icon' => 'fa-times-circle',
                            'description' => 'This order has been cancelled.',
                            'date' => $order->updated_at->format('d M Y, h:i A'),
                            'completed' => false,
                            'active' => true,
                            'cancelled' => true,
                        ],
                    ];
                } else {
                    $statusOrder = ['pending', 'processing', 'shipped', 'delivered'];
                    $currentIndex = array_search($order->order_status, $statusOrder);

                    foreach ($statusOrder as $index => $status) {
                        $step = $allSteps[$status];
                        $step['completed'] = $index <= $currentIndex;
                        $step['active'] = $index === $currentIndex;
                        $step['cancelled'] = false;
                        $trackingSteps[] = $step;
                    }
                }
            }
        }

        return view('frontend.pages.track_order', compact('order', 'trackingSteps', 'searched'));
    }

}

