<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVarient;
use App\Models\DeliveryCharge;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class CartController extends Controller
{

    public function index()
    {
        if (Auth::check()) {
            // For authenticated users - get from database
            $cartItems = Cart::with([
                'product',
                'variant.size'
            ])->where('user_id', Auth::id())
                ->get();

            $cartCount = $cartItems->sum('quantity');
        } else {
            // For guests - get from session
            $sessionCart = session('cart', []);

            $productIds = array_column(array_values($sessionCart), 'product_id');
            $variantIds = array_column(array_values($sessionCart), 'varient_id');

            $products = Product::whereIn('id', $productIds)->get()->keyBy('id');
            $variants = ProductVarient::with(['size'])->whereIn('id', $variantIds)->get()->keyBy('id');

            $cartItems = collect($sessionCart)->map(function ($item, $key) use ($products, $variants) {
                return (object) [
                    'id'      => $key,
                    'product' => $products->get($item['product_id']),
                    'variant' => $variants->get($item['varient_id']),
                    'quantity' => $item['quantity'],
                    'price'   => $item['price'],
                ];
            });

            $cartCount = $cartItems->sum('quantity');
        }
        $deliveryCharge1 = DeliveryCharge::where('status', true)
            ->where('location_type', 'inside_dhaka')
            ->first();

        $deliveryCharge2 = DeliveryCharge::where('status', true)
            ->where('location_type', 'outside_dhaka')
            ->first();




        return view('frontend.pages.cart', compact(
            'cartItems',
            'cartCount',
            'deliveryCharge1',
            'deliveryCharge2'

        ));
    }
    // public function viewCart()
    // {
    //     if (Auth::check()) {
    //         // For authenticated users - get from database
    //         $cartItems = Cart::with([
    //             'product',
    //             'variant',
    //             'variant.color',
    //             'variant.size'
    //         ])->where('user_id', Auth::id())
    //           ->get();

    //         $cartCount = $cartItems->sum('quantity');
    //     } else {
    //         // For guests - get from session
    //         $sessionCart = session('cart', []);
    //         $cartItems = collect($sessionCart)->map(function ($item, $key) {
    //             $product = Product::find($item['product_id']);
    //             $variant = ProductVarient::with(['color', 'size'])->find($item['varient_id']);

    //             return (object)[
    //                 'id' => $key,
    //                 'product' => $product,
    //                 'variant' => $variant,
    //                 'quantity' => $item['quantity'],
    //                 'price' => $item['price']
    //             ];
    //         });

    //         $cartCount = $cartItems->sum('quantity');
    //     }
    //     dd($cartItems );

    //     return view('frontend.pages.cart', compact('cartItems', 'cartCount'));
    // }

    public function addToCart(Request $request)
    {


        try {

            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'varient_id' => 'required|exists:product_varients,id',
                'quantity'   => 'required|integer|min:1',
                'price'      => 'required|numeric',
            ]);

            if (Auth::check()) {
                // For authenticated users - store in database
                $cartItem = Cart::where([
                    'user_id' => Auth::id(),
                    'product_id' => $request->product_id,
                    'varient_id' => $request->varient_id,
                ])->first();

                if ($cartItem) {
                    // Update quantity if item exists
                    $cartItem->quantity += $request->quantity;
                    $cartItem->save();
                } else {
                    // Create new cart item
                    Cart::create([
                        'user_id' => Auth::id(),
                        'product_id' => $request->product_id,
                        'varient_id' => $request->varient_id,
                        'quantity' => $request->quantity,
                        'price' => $request->price
                    ]);
                }

                $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
            } else {
                // For unauthenticated users - store in session
                $cart = session()->get('cart', []);

                $itemKey = $request->product_id . '-' . $request->varient_id;

                if (isset($cart[$itemKey])) {
                    // Update quantity if item exists
                    $cart[$itemKey]['quantity'] += $request->quantity;
                } else {
                    // Add new item
                    $cart[$itemKey] = [
                        'product_id' => $request->product_id,
                        'varient_id' => $request->varient_id,
                        'quantity' => $request->quantity,
                        'price' => $request->price
                    ];
                }

                session()->put('cart', $cart);

                $cartCount = collect($cart)->sum('quantity');
            }

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully',
                'cartCount' => $cartCount
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add product to cart: ' . $e->getMessage()
            ], 500);
        }
    }






    public function updateCart(Request $request)
    {
        try {
            if (Auth::check()) {
                $cart = Cart::where([
                    'id' => $request->cart_id,
                    'user_id' => Auth::id()
                ])->first();

                if (!$cart) {
                    return response()->json(['success' => false, 'message' => 'Cart item not found']);
                }

                $cart->quantity = $request->quantity;
                $cart->save();

                $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
            } else {
                $sessionCart = session()->get('cart', []);

                if (!isset($sessionCart[$request->cart_id])) {
                    return response()->json(['success' => false, 'message' => 'Cart item not found']);
                }

                $sessionCart[$request->cart_id]['quantity'] = $request->quantity;
                session()->put('cart', $sessionCart);

                $cartCount = collect($sessionCart)->sum('quantity');
            }

            return response()->json([
                'success' => true,
                'cartCount' => $cartCount,
                'itemTotal' => $request->quantity * (Auth::check() ? $cart->price : $sessionCart[$request->cart_id]['price'])
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function removeFromCart(Request $request)
    {
        try {
            if (Auth::check()) {
                $cart = Cart::where([
                    'id' => $request->cart_id,
                    'user_id' => Auth::id()
                ])->first();

                if ($cart) {
                    $cart->delete();
                    $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
                } else {
                    return response()->json(['success' => false, 'message' => 'Cart item not found']);
                }
            } else {
                $sessionCart = session()->get('cart', []);
                if (isset($sessionCart[$request->cart_id])) {
                    unset($sessionCart[$request->cart_id]);
                    session()->put('cart', $sessionCart);
                    $cartCount = collect($sessionCart)->sum('quantity');
                } else {
                    return response()->json(['success' => false, 'message' => 'Cart item not found']);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Item removed successfully',
                'cartCount' => $cartCount
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove item: ' . $e->getMessage()
            ], 500);
        }
    }



    public function fetchCartItems()
    {
        if (auth()->check()) {
            $rawItems = Cart::where('user_id', auth()->id())
                ->with(['product', 'variant.size'])
                ->get();

            $cartItems = $rawItems->map(function ($item) {
                return [
                    'id'            => $item->id,
                    'product_name'  => optional($item->product)->product_name ?? 'N/A',
                    'product_image' => optional($item->product)->product_image ?? 'default.png',
                    'size'          => optional(optional($item->variant)->size)->name ?? 'N/A',
                    'quantity'      => $item->quantity,
                    'price'         => $item->price,
                ];
            });
        } else {
            $sessionCart = session('cart', []);
            $productIds  = array_column(array_values($sessionCart), 'product_id');
            $variantIds  = array_column(array_values($sessionCart), 'varient_id');

            $products = Product::whereIn('id', $productIds)->get()->keyBy('id');
            $variants = ProductVarient::with('size')->whereIn('id', $variantIds)->get()->keyBy('id');

            $cartItems = collect($sessionCart)->map(function ($item) use ($products, $variants) {
                $product = $products->get($item['product_id']);
                $variant = $variants->get($item['varient_id']);

                return [
                    'id'            => $item['product_id'] . '-' . $item['varient_id'],
                    'product_name'  => optional($product)->product_name ?? 'N/A',
                    'product_image' => optional($product)->product_image ?? 'default.png',
                    'size'          => optional(optional($variant)->size)->name ?? 'N/A',
                    'quantity'      => $item['quantity'],
                    'price'         => $item['price'],
                ];
            })->values();
        }

        $subtotal = $cartItems->sum(fn($item) => $item['quantity'] * $item['price']);

        return response()->json([
            'success'   => true,
            'cartItems' => $cartItems,
            'subtotal'  => $subtotal,
        ]);
    }



    public function count()
    {
        $count = auth()->check()
            ? \App\Models\Cart::where('user_id', auth()->id())->sum('quantity')
            : collect(session('cart', []))->sum('quantity');

        return response()->json(['success' => true, 'count' => $count]);
    }




}
