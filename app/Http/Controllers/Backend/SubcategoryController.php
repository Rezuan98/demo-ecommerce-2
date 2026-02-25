<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use App\Models\Category;
use Str;

use Illuminate\Support\Facades\Storage;



class SubcategoryController extends Controller
{
    

    public function create(){

        $allcategories = Category::all();
       
        return view('back-end.subcategory.create',compact('allcategories'));
    }

    
    public function store(Request $request) {
        $info = new Subcategory();
        
        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $filename = time() . '.' . $icon->getClientOriginalExtension();
        
           
            $path = $icon->storeAs('subcategory-thumbnail', $filename, 'public');
            
            $info->icon = $path; // Save the path in the database
        }
        
        $info->category_id = $request->category_id;
        $info->name = $request->name;
        $info->slug = Str::slug($request->name);
        
        $info->save();
        return redirect()->back()->with('success', 'Subcategory created successfully!');
    }
    public function index(){

        $info = Subcategory::all();
       
        return view('back-end.subcategory.index',compact('info'));
    }

    public function edit($id){

        $info = Subcategory::where('id',$id)->first();

        $category = Category::all();
        
        return view('back-end.subcategory.edit',compact('info','category'));
    }
    public function update(Request $request){


        if ($request->hasFile('icon')) {
            $subcategory_image = $request->file('icon');
            $filename = time() . '.' . $subcategory_image->getClientOriginalExtension();
            $path = $subcategory_image->storeAs('subcategory_images', $filename, 'public');

            $subcategory =  Subcategory::findOrFail($request->id);
            $subcategory->category_id = $request->category_id;
            $subcategory->name = $request->name;
        
            $subcategory->slug = str::slug($request->name);
            $subcategory->icon = $path;
        
            $subcategory->save();
            return redirect()->route('subcategory.index')->with('info','subcategory updated');
           
        }

        $subcategory =  Subcategory::findOrFail($request->id);
        $subcategory->category_id = $request->category_id;
        $subcategory->name = $request->name;
    
        $subcategory->slug = str::slug($request->name);
        
    
        $subcategory->save();


        return redirect()->route('subcategory.index')->with('info','Subcategory updated');
    }
    public function delete($id){

        // $subcategory = Subcategory::find($id);

       
        // if($subcategory){
          
        //     return redirect()->back()->with('error', 'Please delete the child Product and try again.');;
        // }

        $delete = Subcategory::where('id',$id)->delete();
        return redirect()->back()->with('success', 'Subcategory Deleted!');
    } 

    public function updateStatus(Request $request)
{
    try {
        $subcategory = Subcategory::findOrFail($request->subcategory_id);
        $subcategory->status = $request->status;
        $subcategory->save();
        
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
