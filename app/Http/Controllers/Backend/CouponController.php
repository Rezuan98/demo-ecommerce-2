<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->get();
        return view('back-end.coupon.index', compact('coupons'));
    }

    public function create()
    {
        return view('back-end.coupon.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code',
            'discount_type' => 'required|in:fixed,percentage',
            'discount_amount' => 'required|numeric|min:0.01',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Coupon::create([
            'code' => strtoupper($request->code),
            'discount_type' => $request->discount_type,
            'discount_amount' => $request->discount_amount,
            'min_order_amount' => $request->min_order_amount,
            'max_uses' => $request->max_uses,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->has('status'),
        ]);

        return redirect()->route('coupon.index')->with('success', 'Coupon created successfully');
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('back-end.coupon.edit', compact('coupon'));
    }

    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'discount_type' => 'required|in:fixed,percentage',
            'discount_amount' => 'required|numeric|min:0.01',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $coupon->update([
            'code' => strtoupper($request->code),
            'discount_type' => $request->discount_type,
            'discount_amount' => $request->discount_amount,
            'min_order_amount' => $request->min_order_amount,
            'max_uses' => $request->max_uses,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->has('status'),
        ]);

        return redirect()->route('coupon.index')->with('success', 'Coupon updated successfully');
    }

    public function delete($id)
    {
        Coupon::findOrFail($id)->delete();
        return redirect()->route('coupon.index')->with('success', 'Coupon deleted successfully');
    }

    public function updateStatus(Request $request)
    {
        $coupon = Coupon::findOrFail($request->id);
        $coupon->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully'
        ]);
    }
}
