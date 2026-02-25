<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;

class FlatDiscountController extends Controller
{
    public function index()
    {
        $setting = SiteSetting::first();
        return view('back-end.flat-discount.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'flat_discount_type'   => 'required|in:fixed,percentage',
            'flat_discount_amount' => 'required|numeric|min:0',
        ]);

        $setting = SiteSetting::firstOrCreate([]);

        $setting->flat_discount_active = $request->boolean('flat_discount_active');
        $setting->flat_discount_type   = $request->flat_discount_type;
        $setting->flat_discount_amount = $request->flat_discount_amount;
        $setting->save();

        return back()->with('success', 'Flat discount settings saved successfully.');
    }
}
