<?php
// app/Http/Controllers/Backend/ReviewController.php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::ordered()->get();
        return view('back-end.review.index', compact('reviews'));
    }

    public function create()
    {
        return view('back-end.review.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'            => 'nullable|string|max:255',
            'embed_code'       => 'required|string',
            'all_review_link'  => 'nullable|url',
            'order'            => 'nullable|integer|min:0',
            'status'           => 'nullable|boolean',
        ]);

        // (Optional) very light sanitization: keep only <iframe> tags
        $embed = strip_tags($validated['embed_code'], '<iframe>');

        $review = new Review();
        $review->title           = $validated['title'] ?? null;
        $review->embed_code      = $embed;
        $review->all_review_link = $validated['all_review_link'] ?? null;
        $review->order           = $validated['order'] ?? 0;
        $review->status          = $request->has('status') ? 1 : 1; // default active
        $review->save();

        return redirect()->route('review.index')->with('success', 'Review added successfully!');
    }

    public function edit($id)
    {
        $review = Review::findOrFail($id);
        return view('back-end.review.edit', compact('review'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title'            => 'nullable|string|max:255',
            'embed_code'       => 'required|string',
            'all_review_link'  => 'nullable|url',
            'order'            => 'nullable|integer|min:0',
            'status'           => 'nullable|boolean',
        ]);

        $review = Review::findOrFail($id);

        // (Optional) very light sanitization: keep only <iframe> tags
        $embed = strip_tags($validated['embed_code'], '<iframe>');

        $review->title           = $validated['title'] ?? null;
        $review->embed_code      = $embed;
        $review->all_review_link = $validated['all_review_link'] ?? null;
        $review->order           = $validated['order'] ?? 0;
        $review->status          = $request->has('status') ? 1 : 0;
        $review->save();

        return redirect()->route('review.index')->with('success', 'Review updated successfully!');
    }

    public function delete($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->back()->with('success', 'Review deleted successfully!');
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'review_id' => 'required|integer|exists:reviews,id',
            'status'    => 'required|boolean',
        ]);

        try {
            $review = Review::findOrFail($request->review_id);
            $review->status = (int) $request->status;
            $review->save();

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status!',
            ], 500);
        }
    }

    public function show($id)
    {
        $review = Review::findOrFail($id);
        return view('back-end.review.show', compact('review'));
    }
}
