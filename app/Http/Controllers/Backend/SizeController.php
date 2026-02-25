<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Size;
use Str;

class SizeController extends Controller
{
    public function create(){

        
        return view('back-end.size.create');
    }


    public function store(Request $request){


        


        $info = new Size();
        $info->name = $request->name;
        $info->slug = Str::slug($request->name);
        
        $info->save();
        return redirect()->back()->with('success', 'Size created successfully!');
    }

    public function index(){
        $info = Size::all();
        return view('back-end.size.index',compact('info'));
    }

    public function edit($id){

        $edit = Size::where('id',$id)->first();
        return view('back-end.size.edit',compact('edit'));
    }



    public function update(Request $request){


        
        $color =  Size::findOrFail($request->id);
        
        $color->name = $request->name;
    
        $color->slug = str::slug($request->name);
       
    
        $color->save();


        return redirect()->route('size.index')->with('info','size updated');
    }

    public function delete($id){

          Size::where('id',$id)->delete();
        return redirect()->back()->with('success', 'size Deleted!');
    }

    public function updateStatus(Request $request)
{
    try {
        $category = Size::findOrFail($request->size_id);
        $category->status = $request->status;
        $category->save();
        
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

