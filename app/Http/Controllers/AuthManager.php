<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class AuthManager extends Controller
{
    function signinPost(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if($credentials['email']==='admin@gmail.com' && $credentials['password']==='admin'){
            return redirect()->intended(route('admin'));
        }
        else if (Auth::attempt($credentials)){
            return redirect()->intended(route('home'));
        }
        else{
            return redirect()->route('signin')->with('error', 'Invalid Email or Password');
        }
    }

    function signupPost(Request $request){
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);
    
        $data['first_name'] = $request->fname;
        $data['last_name'] = $request->lname;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password); 
        $data['is_admin'] = $request->email === 'admin@gmail.com' && $request->password === 'admin';
    
        $user = User::create($data);
    
        if(!$user){
            return redirect()->route('signin')->with('error', 'Registration failed');
        }
        return redirect()->route('signin')->with('success', 'Registration successful. Please sign in.');
    }
    function logout(){
        Session::flush();
        Auth::logout();
        return redirect(route('/'));
    }
}
