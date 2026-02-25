<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVarient;
use App\Models\SiteSetting;

class CartServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer(['layouts.frontend', 'frontend.*', 'components.*'], function ($view) {
            $cartItems = [];

            if (auth()->check()) {
                // Fetch cart items from database for authenticated users
                $cartItems = Cart::where('user_id', auth()->id())
                    ->with(['product', 'variant'])
                    ->get();
            } else {
                // Fetch cart items from session for unauthenticated users
                $sessionCart = session('cart', []);
                $productIds  = array_column(array_values($sessionCart), 'product_id');
                $variantIds  = array_column(array_values($sessionCart), 'varient_id');

                $products = Product::whereIn('id', $productIds)->get()->keyBy('id');
                $variants = ProductVarient::whereIn('id', $variantIds)->get()->keyBy('id');

                $cartItems = collect($sessionCart)->map(function ($item) use ($products, $variants) {
                    return (object) [
                        'id'       => $item['product_id'] . '-' . $item['varient_id'],
                        'product'  => $products->get($item['product_id']),
                        'variant'  => $variants->get($item['varient_id']),
                        'quantity' => $item['quantity'],
                        'price'    => $item['price'],
                    ];
                });
            }

            $subtotal = $cartItems->sum(function ($item) {
                return $item->price * $item->quantity;
            });

            // Share cart data with all views
            $view->with('sharedCartItems', $cartItems);
            $view->with('sharedCartSubtotal', $subtotal);

            // Share flat discount settings with all frontend views
            $view->with('flatDiscount', SiteSetting::first());
        });
    }
}
