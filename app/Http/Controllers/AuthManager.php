<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class AuthManager extends Controller
{
    function signinPost(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {  //check user authentication
            $user = Auth::user(); //if we enter get user
    
            if ($user->is_admin) {
                return redirect()->intended(route('admin'));
            } else {
                return redirect()->route('home.view');
            }
        } else {
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

public function toggleUserStatus($id) 
{
    $user = User::findOrFail($id);  //check iif user exists hasab l id
    if (!$user->is_admin) { 
        $user->is_active = !$user->is_active; // set it to opposite, if active bt sir inactive w same lal eleb
        $user->save();
        return redirect()->back();
    }
    return redirect()->back();
}
public function deleteGuest($id) //same mtl abel bas delete
{
    $user = User::findOrFail($id);  
    if ($user->is_guest) { 
        $user->delete();
        return redirect()->back();
    }

    return redirect()->back();
}
    function logout(){
        Session::flush();
        Auth::logout();
        return redirect(route('/'));
    }


    public function getAdminPostsAndUsers()     //returning all posts and users for admin panel
    {
        $posts = Post::all(); // Get all posts from the database
        $users = User::all(); // get all users from db
        $adminCheck = auth()->user()->is_admin;
        return view('admin', compact('users', 'posts', 'adminCheck'));
    }
}