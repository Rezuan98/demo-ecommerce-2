<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVarient;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\GalleryImage;
use App\Models\Slider;
use App\Models\Video;
use App\Models\Review;

class IndexController extends Controller
{
    public function index()
    {
        $new_arrival = Product::select('id', 'product_name', 'slug', 'product_image', 'sale_price', 'discount_type', 'discount_amount', 'created_at', 'status', 'featured')
            ->where('status', 1)
            ->where('featured', 0)
            ->withSum('variants', 'stock_quantity')
            ->with([
                'variants' => function ($query) {
                    $query->select('id', 'product_id', 'stock_quantity', 'size_id');
                },
                'galleryImages' => function ($query) {
                    $query->select('id', 'product_id', 'image');
                }
            ])
            ->latest()
            ->take(20)
            ->get();

        $best_selling = Product::select('id', 'product_name', 'slug', 'product_image', 'sale_price', 'discount_type', 'discount_amount', 'created_at', 'status')
            ->where('status', 1)
            ->withCount('orderItems')
            ->withSum('variants', 'stock_quantity')
            ->with([
                'variants' => function ($query) {
                    $query->select('id', 'product_id', 'stock_quantity', 'size_id');
                },
                'galleryImages' => function ($query) {
                    $query->select('id', 'product_id', 'image');
                }
            ])
            ->orderBy('order_items_count', 'desc')
            ->take(10)
            ->get();

        $featured = Product::select('id', 'product_name', 'slug', 'product_image', 'sale_price', 'discount_type', 'discount_amount', 'created_at', 'status', 'featured')
            ->where('status', 1)
            ->where('featured', 1)
            ->withSum('variants', 'stock_quantity')
            ->with([
                'variants' => function ($query) {
                    $query->select('id', 'product_id', 'stock_quantity', 'size_id');
                },
                'galleryImages' => function ($query) {
                    $query->select('id', 'product_id', 'image');
                }
            ])
            ->take(30)
            ->get();

        $categoryNames = Category::orderBy('id', 'desc')
            ->limit(50)
            ->get();

        $sliderCategory = Category::where('status', 0)
            ->withCount([
                'products as products_count' => function ($q) {
                    $q->whereHas('variants');
                },
            ])
            ->get();

        $featuredCategories = Category::where('featured', 1)->get();

        $featuredCategoryProducts = $featuredCategories->isNotEmpty()
            ? Product::select('id', 'product_name', 'slug', 'product_image', 'sale_price', 'discount_type', 'discount_amount', 'category_id', 'status')
                ->where('status', 1)
                ->whereIn('category_id', $featuredCategories->pluck('id'))
                ->withSum('variants', 'stock_quantity')
                ->with([
                    'galleryImages' => function ($q) {
                        $q->select('id', 'product_id', 'image');
                    }
                ])
                ->get()
                ->groupBy('category_id')
            : collect();

        $sliders = Slider::where('status', true)
            ->orderBy('order')
            ->get();

        $videos = Video::where('status', true)
            ->first();

        $reviews = Review::where('status', 1)
            ->orderBy('order', 'asc')
            ->take(6)
            ->get();

        return view('frontend.master.index', compact('new_arrival', 'best_selling', 'sliders', 'categoryNames', 'videos', 'featured', 'sliderCategory', 'reviews', 'featuredCategories', 'featuredCategoryProducts'));
    }
}
