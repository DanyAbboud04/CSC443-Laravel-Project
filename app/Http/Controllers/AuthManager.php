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
        if (Auth::attempt($credentials)){
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

        $user = User::create($data);

        if(!$user){
            return redirect()->route('signin')->with('error', 'Error');
        }
        return redirect()->route('signin')->with('success', 'Done, sign in please');
    }

    function logout(){
        Session::flush();
        Auth::logout();
        return redirect(route('/'));

    }
}
