<?php
namespace App\Http\Controllers\Backend;



use App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\CashInTypeAssign;
use App\Models\Payment;

class AdditionalController extends Controller
{



   


















      public function getProducts(Request $request){
        $products = Product::where('product_group_id', $request->product_group_id)->get();
        return response()->json($products);
    } 

     public function getCustomers(Request $request){
        $customers = Customer::where('customer_group_id', $request->customer_group_id)
                              ->get();
        return response()->json($customers);
    }

    public function getInvoices(Request $request){
        $invoices = Payment::where('customer_id', $request->customer_id)
                              ->get();
        return response()->json($invoices);
    }

    public function getCustomerGroup(Request $request){
       $customerGroups = CashInTypeAssign::with('customer_group')
                    ->where('cash_in_type_id', $request->cash_in_type_id)
                    ->get();
        return response()->json($customerGroups);
    }

}
