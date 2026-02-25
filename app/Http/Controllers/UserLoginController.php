<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserLoginController extends Controller
{



    public function userRegister()
    {

        return view('frontend.user.user_register');
    }
    public function userLogin()
    {

        return view('frontend.user.user_login');
    }









    public function storeRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Handle image upload
        $imagePath = '';
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('userimages', 'public');
        }

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'image' => $imagePath,
            'password' => $request->password,
            'role' => 0, // Set default role to 0 for regular users
        ]);

        // Login the user after registration
        auth()->login($user);

        return redirect()->route('home')
            ->with('success', 'Registration successful!');
    }
}