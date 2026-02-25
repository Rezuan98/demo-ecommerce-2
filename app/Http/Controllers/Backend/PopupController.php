<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Popup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PopupController extends Controller
{
    public function index()
    {
        $popups = Popup::latest()->get();
        return view('back-end.popup.index', compact('popups'));
    }

    public function create()
    {
        return view('back-end.popup.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'link' => 'nullable|url|max:255',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/popups'), $filename);

            Popup::create([
                'image' => $filename,
                'link' => $request->link,
                'status' => true
            ]);

            return redirect()->route('popup.index')
                           ->with('success', 'Popup created successfully!');
        }

        return redirect()->back()->with('error', 'Failed to upload image');
    }

    public function edit($id)
    {
        $popup = Popup::findOrFail($id);
        return view('back-end.popup.edit', compact('popup'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'link' => 'nullable|url|max:255',
        ]);

        try {
            $popup = Popup::findOrFail($id);

            if ($request->hasFile('image')) {
                // Delete old image
                if ($popup->image && file_exists(public_path('uploads/popups/' . $popup->image))) {
                    try {
                        unlink(public_path('uploads/popups/' . $popup->image));
                    } catch (\Exception $e) {
                        \Log::warning('Could not delete popup image: ' . $e->getMessage());
                    }
                }

                $image = $request->file('image');
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/popups'), $filename);
                $popup->image = $filename;
            }

            $popup->link = $request->link;
            $popup->save();

            return redirect()->route('popup.index')
                            ->with('success', 'Popup updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update popup.');
        }
    }

    public function destroy($id)
    {
        try {
            $popup = Popup::findOrFail($id);

            // Delete image file
            if ($popup->image && file_exists(public_path('uploads/popups/' . $popup->image))) {
                try {
                    unlink(public_path('uploads/popups/' . $popup->image));
                } catch (\Exception $e) {
                    \Log::warning('Could not delete popup image: ' . $e->getMessage());
                }
            }

            $popup->delete();

            return redirect()->route('popup.index')
                            ->with('success', 'Popup deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete popup.');
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            $popup = Popup::findOrFail($request->popup_id);
            $popup->status = $request->status;
            $popup->save();
            
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
