<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Hash;
use Brian2694\Toastr\Facades\Toastr;

class ProfileController extends Controller
{
    public function change_password()
    {
        return view('back-end.profile.change-password');
    }

    public function password_updated(Request $request)
    {

        // Validate the form data
        $request->validate([
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ]);

        $user = Auth::user();
        $user->password = $request->new_password;
        $user->pass = $request->new_password;
        $user->save();
        Toastr::success('Password Updated Successfully', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->back();
    }
}
