<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
use Str;

class UnitController extends Controller
{
    public function create(){

        
        return view('back-end.unit.create');
    }


    public function store(Request $request){


        


        $info = new Unit();
        $info->name = $request->name;
        $info->slug = Str::slug($request->name);
        
        $info->save();
        return redirect()->back()->with('success', 'Unit created successfully!');
    }

    public function index(){
        $info = Unit::all();
        return view('back-end.unit.index',compact('info'));
    }

    public function edit($id){

        $edit = Unit::where('id',$id)->first();
        return view('back-end.unit.edit',compact('edit'));
    }



    public function update(Request $request){


        
        $color =  Unit::findOrFail($request->id);
        
        $color->name = $request->name;
    
        $color->slug = str::slug($request->name);
       
    
        $color->save();


        return redirect()->route('unit.index')->with('info','Unit updated');
    }

    public function delete($id){

        Unit::where('id',$id)->delete();
        return redirect()->back()->with('success', 'Unit Deleted!');
    }

    public function updateStatus(Request $request)
{
    try {
        $unit = Unit::findOrFail($request->unit_id);
        $unit->status = $request->status;
        $unit->save();
        
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
