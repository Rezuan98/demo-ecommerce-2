<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Product;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Size;
use App\Models\Brand;
use App\Models\Unit;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Brian2694\Toastr\Facades\Toastr;

use App\Models\ProductVarient;
use App\Models\GalleryImage;
use League\Csv\Reader;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        $lists = Product::with(['category', 'subcategory', 'brand', 'unit'])
            ->latest()
            ->get();

        return view('back-end.product.index', compact('lists'));
    }

    public function ViewDetails($id)
    {
        $variants = ProductVarient::where('product_id', $id)
            ->with(['product', 'size'])
            ->latest()
            ->get();

        return view('back-end.product.product-details', compact('variants'));
    }

    public function create()
    {

        $allcategories = Category::all();
        $subcategory = Subcategory::all();
        $size = Size::all();
        $brand = Brand::all();
        $unit = Unit::all();

        return view('back-end.product.create', compact('allcategories', 'subcategory', 'size', 'brand', 'unit'));
    }

    public function bulkCreate()
    {
        return view('back-end.product.bulk_create');
    }

    public function bulkStore(Request $request)
    {
        // TODO: Implement bulk product import functionality
        Toastr::info('Bulk import feature is under development', 'Info', ["positionClass" => "toast-top-right"]);
        return redirect()->back();
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'product_image' => 'required|image|max:2048',
            'sizes.*' => 'required|exists:sizes,id',
            'stock_quantity.*' => 'required|numeric|min:0',
            'gallery.*' => 'nullable|image|max:2048',
        ]);

        $productImage = null;

        if ($request->hasFile('product_image')) {
            $file = $request->file('product_image');
            $productImage = 'product_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $productImage);
        }

        if (!$productImage) {
            Toastr::error('Product image is required', 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->back()->withInput();
        }

        if (empty($request->sizes)) {
            Toastr::error('At least one variant is required', 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->back()->withInput();
        }

        $product = new Product();
        $product->product_name = $request->product_name;
        $product->slug = Str::slug($request->product_name);
        $product->product_image = $productImage;
        $product->product_code = 'P' . time() . rand(10000, 99999);
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id;
        $product->brand_id = $request->brand_id;
        $product->unit_id = $request->unit_id;
        $product->description = $request->description;
        $product->discount_type = $request->discount_type;
        $product->discount_amount = $request->discount_amount ?? $request->discount;
        $product->sale_price = $request->price;
        $product->tags = $request->tags;
        $product->status = true;
        $product->save();

        $sizes = $request->sizes;
        $stocks = $request->stock_quantity;

        foreach ($sizes as $key => $sizeId) {
            $variant = new ProductVarient();
            $variant->product_id = $product->id;
            $variant->size_id = $sizeId;
            $variant->stock_quantity = $stocks[$key];
            $variant->sku = $product->product_code . '-' . $sizeId;
            $variant->status = true;
            $variant->save();
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $imageName = 'gallery_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/gallery'), $imageName);

                $galleryImage = new GalleryImage();
                $galleryImage->product_id = $product->id;
                $galleryImage->image = $imageName;
                $galleryImage->save();
            }
        }

        Toastr::success('Product created successfully', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('product.index');
    }

    public function edit($id)
    {
        $product = Product::with(['variants', 'galleryImages'])->findOrFail($id);
        $categories = Category::all();
        $subcategories = Subcategory::where('category_id', $product->category_id)->get();
        $brands = Brand::all();
        $units = Unit::all();
        $sizes = Size::all();

        return view('back-end.product.edit', compact(
            'product',
            'categories',
            'subcategories',
            'brands',
            'units',
            'sizes'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_name' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'product_image' => 'nullable|image|max:5048',
            'sizes.*' => 'required|exists:sizes,id',
            'stock_quantity.*' => 'required|numeric|min:0',
            'gallery.*' => 'nullable|image|max:5048',
        ]);

        $product = Product::findOrFail($id);

        $product->product_name = $request->product_name;
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id;
        $product->brand_id = $request->brand_id;
        $product->unit_id = $request->unit_id;
        $product->description = $request->description;
        $product->sale_price = $request->price;
        $product->discount_type = $request->discount_type;
        $product->discount_amount = $request->discount_amount ?? $request->discount;
        $product->tags = $request->tags;

        if ($request->hasFile('product_image')) {
            if ($product->product_image && file_exists(public_path('uploads/products/' . $product->product_image))) {
                try {
                    unlink(public_path('uploads/products/' . $product->product_image));
                } catch (\Exception $e) {
                    Log::warning('Could not delete old product image: ' . $e->getMessage());
                }
            }

            $image = $request->file('product_image');
            $imageName = 'product_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/products'), $imageName);
            $product->product_image = $imageName;
        }

        $product->save();

        if ($request->has('variant_ids')) {
            foreach ($request->variant_ids as $key => $variantId) {
                $sizeId = $request->sizes[$key] ?? null;

                $variantData = [
                    'product_id' => $product->id,
                    'size_id' => $sizeId,
                    'stock_quantity' => $request->stock_quantity[$key] ?? 0,
                    'sku' => $product->product_code . '-' . $sizeId,
                ];

                if ($variantId) {
                    ProductVarient::where('id', $variantId)->update($variantData);
                } else {
                    ProductVarient::create($variantData);
                }
            }
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $imageName = 'gallery_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/gallery'), $imageName);

                $galleryImage = new GalleryImage();
                $galleryImage->product_id = $product->id;
                $galleryImage->image = $imageName;
                $galleryImage->save();
            }
        }

        Toastr::success('Product updated successfully', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('product.index');
    }


    public function delete($id)
    {
        $product = Product::with(['galleryImages'])->findOrFail($id);

        if ($product->product_image && file_exists(public_path('uploads/products/' . $product->product_image))) {
            try {
                unlink(public_path('uploads/products/' . $product->product_image));
            } catch (\Exception $e) {
                Log::warning('Could not delete product image: ' . $e->getMessage());
            }
        }

        foreach ($product->galleryImages as $galleryImage) {
            if (file_exists(public_path('uploads/gallery/' . $galleryImage->image))) {
                try {
                    unlink(public_path('uploads/gallery/' . $galleryImage->image));
                } catch (\Exception $e) {
                    Log::warning('Could not delete gallery image: ' . $e->getMessage());
                }
            }
        }

        $product->delete();

        Toastr::success('Product deleted successfully', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('product.index');
    }

    public function getSubcategories($categoryId)
    {
        $subcategories = Subcategory::where('category_id', $categoryId)->get();
        return response()->json($subcategories);
    }
    public function updateStatus(Request $request)
    {
        try {
            $product = Product::findOrFail($request->id);
            $product->status = $request->status;
            $product->save();

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status'
            ], 500);
        }
    }

    public function updateFeatured(Request $request)
    {
        try {
            $product = Product::findOrFail($request->id);
            $product->featured = $request->featured;
            $product->save();

            return response()->json([
                'success' => true,
                'message' => 'Featured status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update featured status'
            ], 500);
        }
    }

    public function updateVarientStatus(Request $request)
    {
        try {
            $variant = ProductVarient::findOrFail($request->id);
            $variant->featured = $request->featured;
            $variant->save();

            return response()->json([
                'success' => true,
                'message' => 'Variant featured status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update variant featured status'
            ], 500);
        }
    }

    public function deleteGalleryImage($id)
    {
        try {
            $galleryImage = GalleryImage::findOrFail($id);

            $imagePath = public_path('uploads/gallery/' . $galleryImage->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            $galleryImage->delete();

            return response()->json([
                'success' => true,
                'message' => 'Gallery image deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete image'
            ], 500);
        }
    }


    public function duplicateProduct($id)
    {
        try {
            $originalProduct = Product::with(['variants', 'galleryImages'])->findOrFail($id);

            $newProduct = $originalProduct->replicate();
            $newProduct->product_name = $originalProduct->product_name . ' (Copy)';
            $newProduct->slug = Str::slug($newProduct->product_name);
            $newProduct->product_code = 'P' . time() . rand(10000, 99999);

            if ($originalProduct->product_image) {
                $originalPath = public_path('uploads/products/') . $originalProduct->product_image;
                $extension = pathinfo($originalProduct->product_image, PATHINFO_EXTENSION);
                $newImageName = 'product_' . time() . '_' . uniqid() . '.' . $extension;
                $newPath = public_path('uploads/products/') . $newImageName;

                if (file_exists($originalPath)) {
                    copy($originalPath, $newPath);
                    $newProduct->product_image = $newImageName;
                }
            }

            $newProduct->save();

            foreach ($originalProduct->variants as $variant) {
                $newVariant = $variant->replicate();
                $newVariant->product_id = $newProduct->id;
                $newVariant->sku = $newProduct->product_code . '-' . $variant->size_id;
                $newVariant->save();
            }

            foreach ($originalProduct->galleryImages as $gallery) {
                $originalPath = public_path('uploads/gallery/') . $gallery->image;
                $extension = pathinfo($gallery->image, PATHINFO_EXTENSION);
                $newImageName = 'gallery_' . time() . '_' . uniqid() . '.' . $extension;
                $newPath = public_path('uploads/gallery/') . $newImageName;

                if (file_exists($originalPath)) {
                    copy($originalPath, $newPath);

                    $newGallery = new GalleryImage();
                    $newGallery->product_id = $newProduct->id;
                    $newGallery->image = $newImageName;
                    $newGallery->save();
                }
            }

            Toastr::success('Product duplicated successfully', 'Success', ["positionClass" => "toast-top-right"]);
            return redirect()->route('product.index');
        } catch (\Exception $e) {
            Toastr::error('Failed to duplicate product', 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
    }

    public function deleteVariant($id)
    {
        try {
            $variant = ProductVarient::findOrFail($id);
            $variant->delete();

            return response()->json([
                'success' => true,
                'message' => 'Variant deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete variant'
            ], 500);
        }
    }
}
