<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Size;

class QuickCreateController extends Controller
{
    public function storeCategory(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);

        $category = Category::create([
            'name'   => trim($request->name),
            'slug'   => Str::slug(trim($request->name)),
            'status' => true,
        ]);

        return response()->json(['success' => true, 'id' => $category->id, 'name' => $category->name]);
    }

    public function storeSubcategory(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        $subcategory = Subcategory::create([
            'name'        => trim($request->name),
            'category_id' => $request->category_id,
            'slug'        => Str::slug(trim($request->name)),
            'status'      => true,
        ]);

        return response()->json(['success' => true, 'id' => $subcategory->id, 'name' => $subcategory->name]);
    }

    public function storeBrand(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);

        $brand = Brand::create([
            'name'   => trim($request->name),
            'slug'   => Str::slug(trim($request->name)),
            'status' => true,
        ]);

        return response()->json(['success' => true, 'id' => $brand->id, 'name' => $brand->name]);
    }

    public function storeUnit(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);

        $unit = Unit::create([
            'name'   => trim($request->name),
            'slug'   => Str::slug(trim($request->name)),
            'status' => true,
        ]);

        return response()->json(['success' => true, 'id' => $unit->id, 'name' => $unit->name]);
    }

    public function storeSize(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);

        $size = Size::create([
            'name'   => trim($request->name),
            'slug'   => Str::slug(trim($request->name)),
            'status' => true,
        ]);

        return response()->json(['success' => true, 'id' => $size->id, 'name' => $size->name]);
    }
}
