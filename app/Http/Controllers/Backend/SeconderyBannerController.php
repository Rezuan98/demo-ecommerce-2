<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SeconderyBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SeconderyBannerController extends Controller
{
    public function index()
    {
        $banners = SeconderyBanner::orderBy('position')->get();
        return view('back-end.secondery_banner.index', compact('banners'));
    }

    public function create()
    {
        return view('back-end.secondery_banner.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'nullable|string|max:255',
            'image'    => 'required|image|mimes:jpeg,jpg,png,webp|max:5120',
            'link'     => 'nullable|url|max:255',
            'position' => 'required|in:0,1',
        ], [
            'image.required' => 'Please select a banner image.',
            'image.image'    => 'The file must be a valid image.',
            'image.mimes'    => 'Only JPG, PNG, and WebP images are allowed.',
            'image.max'      => 'The banner image must not exceed 5 MB.',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/secondary-banners', $filename);

            SeconderyBanner::create([
                'title' => $request->title,
                'image' => $filename,
                'link' => $request->link,
                'position' => $request->position,
                'status' => true
            ]);

            return redirect()->route('secondary-banner.index')
                           ->with('success', 'Banner added successfully!');
        }

        return redirect()->back()->with('error', 'Failed to upload image');
    }

    public function edit($id)
    {
        $banner = SeconderyBanner::findOrFail($id);
        return view('back-end.secondery_banner.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'    => 'nullable|string|max:255',
            'image'    => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'link'     => 'nullable|url|max:255',
            'position' => 'required|in:0,1',
        ], [
            'image.image' => 'The file must be a valid image.',
            'image.mimes' => 'Only JPG, PNG, and WebP images are allowed.',
            'image.max'   => 'The banner image must not exceed 5 MB.',
        ]);

        $banner = SeconderyBanner::findOrFail($id);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($banner->image && Storage::exists('public/secondary-banners/' . $banner->image)) {
                Storage::delete('public/secondary-banners/' . $banner->image);
            }

            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/secondary-banners', $filename);
            $banner->image = $filename;
        }

        $banner->title = $request->title;
        $banner->link = $request->link;
        $banner->position = $request->position;
        $banner->save();

        return redirect()->route('secondary-banner.index')
                        ->with('success', 'Banner updated successfully!');
    }

    public function destroy($id)
    {
        $banner = SeconderyBanner::findOrFail($id);

        if ($banner->image && Storage::exists('public/secondary-banners/' . $banner->image)) {
            Storage::delete('public/secondary-banners/' . $banner->image);
        }

        $banner->delete();

        return redirect()->route('secondary-banner.index')
                        ->with('success', 'Banner deleted successfully!');
    }

    public function updateStatus(Request $request)
    {
        try {
            $banner = SeconderyBanner::findOrFail($request->banner_id);
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