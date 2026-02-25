<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Str;

class BrandController extends Controller
{
    public function create(){

        
        return view('back-end.brand.create');
    }


    public function store(Request $request){


        


        $info = new Brand();
        $info->name = $request->name;
        $info->slug = Str::slug($request->name);
        
        $info->save();
        return redirect()->back()->with('success', 'Brand created successfully!');
    }

    public function index(){
        $info = Brand::all();
        return view('back-end.brand.index',compact('info'));
    }

    public function edit($id){

        $edit = Brand::where('id',$id)->first();
        return view('back-end.brand.edit',compact('edit'));
    }



    public function update(Request $request,$id){


        
        $brand =  Brand::findOrFail($id);
        
        $brand->name = $request->name;
    
        $brand->slug = str::slug($request->name);
       
    
        $brand->save();


        return redirect()->route('brand.index')->with('info','Brand updated');
    }

    public function delete($id){

          Brand::where('id',$id)->delete();
        return redirect()->back()->with('success', 'Brand Deleted!');
    }

    public function updateStatus(Request $request)
{
    try {
        $brand = Brand::findOrFail($request->brand_id);
        $brand->status = $request->status;
        $brand->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to update status!'
        ]);
    }
}
}
