<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Cart;
use App\Models\ProductVarient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function success(Request $request)
    {
        $tranId = $request->tran_id;
        $order = Order::where('order_number', $tranId)->first();

        if ($order && $request->status == 'VALID') {
            $order->payment_status = 'paid';
            $order->save();

            $payment = Payment::where('order_id', $order->id)->first();
            if ($payment) {
                $payment->status = 'completed';
                $payment->transaction_id = $request->bank_tran_id;
                $payment->paid_at = now();
                $payment->save();
            }

            $this->completeOrder($order);
            return redirect()->route('order.success', $order->order_number)
                           ->with('success', 'Payment successful!');
        }

        return redirect()->route('cart.index')->with('error', 'Payment failed!');
    }

    public function fail(Request $request)
    {
        $tranId = $request->tran_id;
        $order = Order::where('order_number', $tranId)->first();

        if ($order) {
            $payment = Payment::where('order_id', $order->id)->first();
            if ($payment) {
                $payment->status = 'failed';
                $payment->save();
            }
        }

        return redirect()->route('cart.index')->with('error', 'Payment failed! Please try again.');
    }

    public function cancel(Request $request)
    {
        $tranId = $request->tran_id;
        $order = Order::where('order_number', $tranId)->first();

        if ($order) {
            $payment = Payment::where('order_id', $order->id)->first();
            if ($payment) {
                $payment->status = 'cancelled';
                $payment->save();
            }
        }

        return redirect()->route('cart.index')->with('info', 'Payment cancelled.');
    }

    private function completeOrder($order)
    {
        DB::transaction(function () use ($order) {
            if (Auth::check()) {
                $cartItems = Cart::where('user_id', Auth::id())->with('variant')->get();
                foreach ($cartItems as $item) {
                    if ($item->variant) {
                        $variant = ProductVarient::lockForUpdate()->find($item->variant->id);
                        if ($variant && $variant->stock_quantity >= $item->quantity) {
                            $variant->decrement('stock_quantity', $item->quantity);
                        }
                    }
                }
                Cart::where('user_id', Auth::id())->delete();
            } else {
                $cart = session()->get('cart', []);
                foreach ($cart as $item) {
                    $variant = ProductVarient::lockForUpdate()->find($item['varient_id']);
                    if ($variant && $variant->stock_quantity >= $item['quantity']) {
                        $variant->decrement('stock_quantity', $item['quantity']);
                    }
                }
                session()->forget(['cart']);
            }
        });
    }
}