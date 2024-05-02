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

    public function deactivateUser($id)
{
    $user = User::findOrFail($id);
    if (!$user->is_admin) { // Ensure admins cannot be deactivated by mistake.
        $user->is_active = false;
        $user->save();
        return redirect()->back()->with('success', 'User has been successfully deactivated.');
    }
    return redirect()->back()->with('error', 'Cannot deactivate this user.');
}

public function toggleUserStatus($id)
{
    $user = User::findOrFail($id);
    if (!$user->is_admin) { // Ensure admins cannot be deactivated by mistake.
        $user->is_active = !$user->is_active; // Toggle the active status.
        $user->save();
        $statusMessage = $user->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "User has been successfully {$statusMessage}.");
    }
    return redirect()->back()->with('error', 'Cannot modify this user.');
}

    function logout(){
        Session::flush();
        Auth::logout();
        return redirect(route('/'));
    }
}
