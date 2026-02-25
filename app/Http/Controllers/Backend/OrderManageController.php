<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

use Barryvdh\DomPDF\Facade\Pdf as PDF;

class OrderManageController extends Controller
{
    public function index()
    {


        $orders = Order::with(['items'])
            ->latest()
            ->get();

        return view('back-end.order.index', compact('orders'));
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:orders,id',
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $order = Order::findOrFail($request->id);
        $order->order_status = $request->status;
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully'
        ]);
    }

    public function orderDetails($id)
    {
        $order = Order::with(['items.product', 'items.variant'])
            ->findOrFail($id);



        return view('back-end.order.order_details', compact('order'));
    }


    public function downloadPDF($id)
    {
        try {
            $order = Order::with(['items.product', 'items.variant.size'])
                ->findOrFail($id);

            $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Invoice</title>
            <style>
                body { font-family: DejaVu Sans, sans-serif; font-size: 12px; margin: 20px; }
                .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
                .info-section { margin-bottom: 20px; }
                .info-row { margin-bottom: 5px; }
                .label { font-weight: bold; display: inline-block; width: 120px; }
                .table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                .table th { background-color: #f5f5f5; font-weight: bold; }
                .totals { margin-top: 20px; text-align: right; }
                .total-row { margin-bottom: 5px; }
                .grand-total { font-size: 14px; font-weight: bold; border-top: 2px solid #333; padding-top: 5px; }
            </style>
        </head>
        <body>
            <div class="header">
                <h2>' . config('app.name') . '</h2>
                <h3>INVOICE</h3>
            </div>

            <div class="info-section">
                <div class="info-row"><span class="label">Order Number:</span> ' . $order->order_number . '</div>
                <div class="info-row"><span class="label">Date:</span> ' . $order->created_at->format('d M Y, h:i A') . '</div>
                <div class="info-row"><span class="label">Status:</span> ' . ucfirst($order->order_status) . '</div>
                <div class="info-row"><span class="label">Payment:</span> ' . ucfirst($order->payment_method) . ' (' . ucfirst($order->payment_status) . ')</div>
            </div>

            <div class="info-section">
                <h4>Customer Details:</h4>
                <div class="info-row"><span class="label">Name:</span> ' . $order->name . '</div>
                <div class="info-row"><span class="label">Email:</span> ' . $order->email . '</div>
                <div class="info-row"><span class="label">Phone:</span> ' . $order->phone . '</div>
                <div class="info-row"><span class="label">Address:</span> ' . $order->address . ', ' . $order->city . '</div>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Variant</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>';

            foreach ($order->items as $item) {
                $variant = ($item->variant_size ?? 'N/A');
                $html .= '
                    <tr>
                        <td>' . ($item->product->product_name ?? 'N/A') . '</td>
                        <td>' . $variant . '</td>
                        <td>' . $item->quantity . '</td>
                        <td>Tk' . number_format($item->price, 2) . '</td>
                        <td>Tk' . number_format($item->subtotal, 2) . '</td>
                    </tr>';
            }

            $html .= '
                </tbody>
            </table>

            <div class="totals">
                <div class="total-row">Subtotal: Tk' . number_format($order->subtotal, 2) . '</div>
                <div class="total-row">Shipping: Tk' . number_format($order->shipping_charge, 2) . '</div>
                <div class="total-row">Tax: Tk' . number_format($order->tax, 2) . '</div>
                <div class="grand-total">Total: Tk' . number_format($order->total, 2) . '</div>
            </div>';

            if ($order->bkash_transaction_id) {
                $html .= '
            <div class="info-section">
                <div class="info-row"><span class="label">Transaction ID:</span> ' . $order->bkash_transaction_id . '</div>
            </div>';
            }

            if ($order->order_notes) {
                $html .= '
            <div class="info-section">
                <h4>Order Notes:</h4>
                <p>' . $order->order_notes . '</p>
            </div>';
            }

            $html .= '
            <div style="margin-top: 40px; text-align: center; font-size: 10px; color: #666;">
                Generated on ' . now()->format('d M Y, h:i A') . '
            </div>
        </body>
        </html>';

            $pdf = PDF::loadHTML($html);
            $pdf->setPaper('A4', 'portrait');

            return $pdf->download('Invoice-' . $order->order_number . '.pdf');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }

    // Add these methods to OrderManageController.php
    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:orders,id',
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        Order::whereIn('id', $request->order_ids)
            ->update(['order_status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Order statuses updated successfully'
        ]);
    }

    public function bulkUpdatePayment(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:orders,id',
            'payment_status' => 'required|in:pending,paid,failed'
        ]);

        Order::whereIn('id', $request->order_ids)
            ->update(['payment_status' => $request->payment_status]);

        return response()->json([
            'success' => true,
            'message' => 'Payment statuses updated successfully'
        ]);
    }

}
