<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest']);
    }
    //Just showing the Regiter page
    public function index()
    {
        return view('auth.register');
    }
    
    public function store(Request $request)
    {
        //validation of form data
        $this->validate($request, [
            'name'=>'required|max:255',
            'username'=>'required|unique:users|max:255',
            'email'=>'required|unique:users|email|max:255',
            'password'=>'required|confirmed',
        ]);

        //Saving data to database
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),  
        ]);

        auth()->attempt($request->only('email','password'));
        //After Saving the data to database this will redirected to dashboard view page
        return redirect()->route('dashboard');
    }
}
