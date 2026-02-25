<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SpecialBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;


class SpecialBannerController extends Controller
{
    public function index()
    {
        $banner = SpecialBanner::first();
        return view('back-end.special_banner.index', compact('banner'));
    }



public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg',
    ]);

    $banner = SpecialBanner::first() ?? new SpecialBanner();

    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($banner->image && Storage::exists('public/special-banner/' . $banner->image)) {
            Storage::delete('public/special-banner/' . $banner->image);
        }

        // Store new image
        $image = $request->file('image');
        $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

        $image->storeAs('public/special-banner', $filename);

        $banner->image = $filename;
    }

    $banner->title = $request->title;
    $banner->description = $request->description;
    $banner->status = $request->has('status');
    $banner->save();

    return redirect()->back()->with('success', 'Special banner updated successfully!');
}


    public function updateStatus(Request $request)
    {
        try {
            $banner = SpecialBanner::findOrFail($request->banner_id);
            $banner->status = $request->status;
            $banner->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status!'
            ]);
        }
    }
}