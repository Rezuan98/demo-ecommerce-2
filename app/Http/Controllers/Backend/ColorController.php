<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Color;
use Str;

class ColorController extends Controller
{
    public function create(){


        return view('back-end.color.create');
    }


    public function store(Request $request){


        


        $info = new Color();
        $info->name = $request->name;
        $info->slug = Str::slug($request->name);
        $info->code = $request->code;
        $info->save();
        return redirect()->back()->with('success', 'Color created successfully!');
    }

    public function index(){
        $info = Color::all();
        return view('back-end.color.index',compact('info'));
    }

    public function edit($id){

        $edit = Color::where('id',$id)->first();
        return view('back-end.color.edit',compact('edit'));
    }



    public function update(Request $request){


        
        $color =  Color::findOrFail($request->id);
        
        $color->name = $request->name;
    
        $color->slug = str::slug($request->name);
        $color->code = $request->code;
    
        $color->save();


        return redirect()->route('color.index')->with('info','color updated');
    }

    public function delete($id){

          Color::where('id',$id)->delete();
        return redirect()->back()->with('success', 'Color Deleted!');
    }

    public function updateStatus(Request $request)
{
    try {
        $category = Color::findOrFail($request->color_id);
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
