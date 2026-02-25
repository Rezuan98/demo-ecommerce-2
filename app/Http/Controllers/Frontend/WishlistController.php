<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    /**
     * Toggle a product in the user's wishlist (AJAX).
     */
    public function toggle(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        $product = Product::findOrFail($request->product_id);
        $user = auth()->user();

        if ($user->wish->contains($product->id)) {
            $user->wish()->detach($product->id);
            $added = false;
            $message = 'Removed from wishlist';
        } else {
            $user->wish()->attach($product->id);
            $added = true;
            $message = 'Added to wishlist';
        }

        return response()->json([
            'success' => true,
            'added' => $added,
            'message' => $message,
            'count' => $user->wish()->count(),
        ]);
    }

    /**
     * Check if the current user has wishlisted a product (AJAX).
     */
    public function check($productId)
    {
        $wishlisted = auth()->user()->wish->contains($productId);

        return response()->json([
            'wishlisted' => $wishlisted,
        ]);
    }

    /**
     * Wishlist page — show all wishlisted products.
     */
    public function index()
    {
        $products = auth()->user()->wish()->with(['galleryImages', 'variants'])->get();

        return view('frontend.pages.wishlist', compact('products'));
    }

    /**
     * AJAX login (for auth modal).
     */
    public function ajaxLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'wishlist_count' => auth()->user()->wish()->count(),
            ]);
        }

        return response()->json([
            'success' => false,
            'errors' => ['email' => ['Invalid email or password.']],
        ], 422);
    }

    /**
     * AJAX register (for auth modal).
     */
    public function ajaxRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password,
            'role' => 0,
            'image' => '',
            'address' => '',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'message' => 'Registration successful',
            'wishlist_count' => 0,
        ]);
    }
}
