<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class SearchController extends Controller
{
    public function liveSearch(Request $request)
    {
        $query = $request->get('query', '');

        // Convert query to lowercase for case-insensitive search
        $searchTerm = strtolower($query);

        // Fetch products using LOWER() function for case-insensitive search
        $products = Product::with(['category', 'subcategory'])
            ->whereRaw('LOWER(product_name) LIKE ?', ["%{$searchTerm}%"])
            ->orWhereRaw('LOWER(tags) LIKE ?', ["%{$searchTerm}%"])
            ->orWhereRaw('LOWER(description) LIKE ?', ["%{$searchTerm}%"])
            ->orWhereHas('category', function ($q) use ($searchTerm) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$searchTerm}%"]);
            })
            ->orWhereHas('subcategory', function ($q) use ($searchTerm) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$searchTerm}%"]);
            })
            ->take(10) // Limit to 10 results
            ->get();

        return response()->json($products);
    }
}
