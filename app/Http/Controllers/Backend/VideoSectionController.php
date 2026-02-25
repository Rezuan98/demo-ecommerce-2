<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoSectionController extends Controller
{
    // Change this in VideoSectionController
public function index()
{
    $videos = Video::latest()->get(); // Get all videos as a collection
    return view('back-end.video.index', compact('videos'));
}
   // Change this in store method
public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'subtitle' => 'nullable|string',
        'thumbnail' => 'nullable|image|max:2048',
        'video_url' => 'required|url',
    ]);

    // Create new video instead of getting first
    $video = new Video();
    
    if ($request->hasFile('thumbnail')) {
        $image = $request->file('thumbnail');
        $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/video', $filename);
        $video->thumbnail = $filename;
    }

    $video->title = $request->title;
    $video->subtitle = $request->subtitle;
    $video->video_url = $request->video_url;
    $video->status = $request->has('status');
    $video->save();

    return redirect()->back()->with('success', 'Video added successfully!');
}

    public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'subtitle' => 'nullable|string',
        'thumbnail' => 'nullable|image|max:2048',
        'video_url' => 'required|url',
    ]);

    $video = Video::findOrFail($id);
    
    if ($request->hasFile('thumbnail')) {
        if ($video->thumbnail && Storage::exists('public/video/' . $video->thumbnail)) {
            Storage::delete('public/video/' . $video->thumbnail);
        }
        
        $image = $request->file('thumbnail');
        $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/video', $filename);
        $video->thumbnail = $filename;
    }

    $video->title = $request->title;
    $video->subtitle = $request->subtitle;
    $video->video_url = $request->video_url;
    $video->status = $request->has('status');
    $video->save();

    return redirect()->back()->with('success', 'Video updated successfully!');
}
public function destroy($id)
{
    try {
        $video = Video::findOrFail($id);
        
        // Delete thumbnail if exists
        if ($video->thumbnail && Storage::exists('public/video/' . $video->thumbnail)) {
            Storage::delete('public/video/' . $video->thumbnail);
        }
        
        $video->delete();
        
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Video deleted successfully!');
    } catch (\Exception $e) {
        // Redirect back with an error message in case of failure
        return redirect()->back()->with('error', 'Failed to delete video!');
    }
}

   public function updateStatus(Request $request)
{
    try {
        $video = Video::findOrFail($request->video_id);
        $video->status = $request->status ? 1 : 0;  // Ensure boolean conversion
        $video->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!'
        ]);
    } catch (\Exception $e) {
        \Log::error('Video status update error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Failed to update status!'
        ], 500);
    }
}
}