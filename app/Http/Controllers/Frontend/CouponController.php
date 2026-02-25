<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function apply(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
            'subtotal' => 'required|numeric|min:0',
        ]);

        $coupon = Coupon::where('code', strtoupper($request->coupon_code))->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code'
            ]);
        }

        if (!$coupon->isValid($request->subtotal)) {
            $message = 'This coupon is not valid';

            if (!$coupon->status) {
                $message = 'This coupon is inactive';
            } elseif (now()->lt($coupon->start_date)) {
                $message = 'This coupon is not yet active';
            } elseif (now()->gt($coupon->end_date)) {
                $message = 'This coupon has expired';
            } elseif ($coupon->max_uses !== null && $coupon->used_count >= $coupon->max_uses) {
                $message = 'This coupon has reached its usage limit';
            } elseif ($coupon->min_order_amount && $request->subtotal < $coupon->min_order_amount) {
                $message = 'Minimum order amount is ৳' . number_format((float) $coupon->min_order_amount, 0);
            }

            return response()->json([
                'success' => false,
                'message' => $message
            ]);
        }

        $discount = $coupon->calculateDiscount($request->subtotal);

        // Store in session
        session()->put('coupon', [
            'code' => $coupon->code,
            'discount_type' => $coupon->discount_type,
            'discount_amount' => $coupon->discount_amount,
            'calculated_discount' => $discount,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully!',
            'discount' => $discount,
            'coupon_code' => $coupon->code,
            'discount_type' => $coupon->discount_type,
            'discount_value' => $coupon->discount_amount,
        ]);
    }

    public function remove()
    {
        session()->forget('coupon');

        return response()->json([
            'success' => true,
            'message' => 'Coupon removed successfully'
        ]);
    }
}
