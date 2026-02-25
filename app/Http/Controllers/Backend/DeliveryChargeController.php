<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\DeliveryCharge;
use Illuminate\Http\Request;

class DeliveryChargeController extends Controller
{
    public function index()
    {
        $charges = DeliveryCharge::all();
        return view('back-end.delivery_charge.index', compact('charges'));
    }
    public function create()
{
    return view('back-end.delivery_charge.create');
}
    public function store(Request $request)
    {
        $request->validate([
            'location_type' => 'required|unique:delivery_charges',
            'charge' => 'required|numeric|min:0',
        ]);
    
        DeliveryCharge::create([
            'location_type' => $request->location_type,
            'charge' => $request->charge,
            'status' => $request->has('status')
        ]);
    
        return redirect()->route('delivery-charges.index')
            ->with('success', 'Delivery charge created successfully');
    }
    public function update(Request $request, DeliveryCharge $charge)
    {
        $request->validate([
            'charge' => 'required|numeric|min:0'
        ]);

        $charge->update([
            'charge' => $request->charge
        ]);

        return redirect()->back()->with('success', 'Delivery charge updated successfully');
    }

    public function updateStatus(Request $request, DeliveryCharge $charge)
    {
        $charge->update([
            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully'
        ]);
    }

    public function getDeliveryCharges()
    {
        $charges = DeliveryCharge::where('status', true)->get()
            ->pluck('charge', 'location_type')
            ->toArray();
            
        return response()->json($charges);
    }
}