<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gtm;

class GtmController extends Controller
{
    public function create(){
              $data = Gtm::first();
              
        return view('back-end.gtm.create', compact('data'));
    }



    public function store(Request $request)
    {
       
        

        $code = new Gtm(); 
        $code->gtm_code = $request->gtm_code; 
        
        $code->save(); 

        return redirect()->route('gtm.create')->with('success', 'Code saved successfully!');
    }

    // Retrieve all codes
    public function update(Request $request)
    {
        // $request->validate([
        //     'gtm_code' => 'required|string|max:255',
        //     'pixel_code' => 'required|string|max:255',
        //     'pageId' => 'required|string|max:255',
        // ]);
    $id = $request->id;
        Gtm::where('id', $id)->update([
            'gtm_code' => $request->gtm_code,
            
        ]);
    
        return redirect()->route('gtm.create')->with('success', 'Code updated successfully!');
    }
    



    
}
