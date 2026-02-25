<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

  
    public function index()
    {  


        $totalsales = OrderItem::sum('subtotal');
        $total_order = OrderItem::count('subtotal');
        $total_customer = User::where('role','0')->count();
// Get today's date at the start and end of the day
$today_start = now()->startOfDay();
$today_end = now()->endOfDay();
 // Get order status counts
 $pending_orders = Order::where('order_status', 'pending')->count();
 $confirmed_orders = Order::where('order_status', 'confirm')->count();
 $processing_orders = Order::where('order_status', 'processing')->count();
 $pickup_orders = Order::where('order_status', 'pickup')->count();
 $ontheway_orders = Order::where('order_status', 'on_the_way')->count();
 $delivered_orders = Order::where('order_status', 'delivered')->count();
 $cancelled_orders = Order::where('order_status', 'cancelled')->count();

// Get today's total sales from order items
$today_sales = OrderItem::whereHas('order', function($query) use ($today_start, $today_end) {
    $query->whereBetween('created_at', [$today_start, $today_end]);
})->sum('subtotal');

       

          
        return view('back-end.home.home',compact(
        'totalsales',
        'total_order',
        'total_customer',
        'today_sales',
        'pending_orders',
        'confirmed_orders',
        'processing_orders',
        'pickup_orders',
        'ontheway_orders',
        'delivered_orders',
        'cancelled_orders'));
    }

    public function allUsers(){

        $item = User::all();

       

        return view('back-end.users.users',['item'=>$item]);
    }

    public function deleteUser($id){

        

        User::where('id',$id)->delete();

        return redirect()->route('all.users');
    }

    





    public function changeUserRole(Request $request)
{
    try {
        \Log::info('Role Update Request:', $request->all());
        
        $user = User::findOrFail($request->user_id);
        $user->role = $request->role;
        
        \Log::info('User Before Save:', [
            'user_id' => $user->id,
            'old_role' => $user->getOriginal('role'),
            'new_role' => $user->role
        ]);
        
        $saved = $user->save();
        
        \Log::info('Save Result:', ['saved' => $saved]);

        if($saved) {
            return response()->json([
                'success' => true,
                'message' => 'User role updated successfully',
                'new_role' => $user->role
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to save user role'
        ]);

    } catch (\Exception $e) {
        \Log::error('Role Update Error:', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Failed to update user role: ' . $e->getMessage()
        ]);
    }
}
}
