<?php

namespace App\Http\Controllers\Backend;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;

use Str;

use Illuminate\Support\Facades\Storage;



class CategoryController extends Controller
{

    public function create(){
        return view('back-end.category.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:4096',
        ], [
            'name.required' => 'Category name is required.',
            'icon.image'    => 'The icon must be a valid image.',
            'icon.mimes'    => 'Only JPG, PNG, and WebP images are allowed.',
            'icon.max'      => 'The category image must not exceed 4 MB.',
        ]);

        $info = new Category();

        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $filename = time() . '.' . $icon->getClientOriginalExtension();
            $path = $icon->storeAs('category-thumbnail', $filename, 'public');
            $info->icon = $path;
        }

        $info->name     = $request->name;
        $info->slug     = Str::slug($request->name);
        $info->featured = $request->has('featured') ? 1 : 0;

        $info->save();

        return redirect()->back()->with('success', 'Category created successfully!');
    }

    public function index(){
        $info = Category::all();
        return view('back-end.category.index', compact('info'));
    }

    public function edit($id){
        $info = Category::where('id', $id)->first();
        return view('back-end.category.edit', compact('info'));
    }

    public function update(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:4096',
        ], [
            'name.required' => 'Category name is required.',
            'icon.image'    => 'The icon must be a valid image.',
            'icon.mimes'    => 'Only JPG, PNG, and WebP images are allowed.',
            'icon.max'      => 'The category image must not exceed 4 MB.',
        ]);

        if ($request->hasFile('icon')) {
            $category_image = $request->file('icon');
            $filename = time() . '.' . $category_image->getClientOriginalExtension();
            $path = $category_image->storeAs('category-thumbnail', $filename, 'public');

            $category = Category::findOrFail($request->id);
            $category->name     = $request->name;
            $category->slug     = Str::slug($request->name);
            $category->icon     = $path;
            $category->featured = $request->has('featured') ? 1 : 0;
            $category->save();

            return redirect()->route('category.index')->with('info', 'category updated');
        }

        $category = Category::findOrFail($request->id);
        $category->name     = $request->name;
        $category->slug     = Str::slug($request->name);
        $category->featured = $request->has('featured') ? 1 : 0;
        $category->save();

        return redirect()->route('category.index')->with('info', 'category updated');
    }

    public function delete($id){
        $category = Category::find($id);
        $subcat   = Subcategory::where('category_id', $category->id)->first();

        Category::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Category Deleted!');
    }

    public function updateStatus(Request $request)
    {
        try {
            $category = Category::findOrFail($request->category_id);
            $category->status = $request->status;
            $category->save();

            return response()->json(['success' => true,  'message' => 'Status updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update status!']);
        }
    }

    public function updateFeatured(Request $request)
    {
        try {
            $category = Category::findOrFail($request->category_id);
            $category->featured = $request->featured;
            $category->save();

            return response()->json(['success' => true,  'message' => 'Featured updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update featured!']);
        }
    }
}
