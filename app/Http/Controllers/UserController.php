<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // UserController.php

    public function index()
    {
        $users = User::all(); // get all users from db
        return view('admin', compact('users')); // pass all users to the view admin
    }

    public function getUser()
    {
        $user = Auth::user();  //get current user
        return view('profile', compact('user'));
    }

    public function updateFirstName(Request $request)
{
    $user = Auth::user();
    $user->first_name = $request->first_name;
    $user->save();

    return back()->with('success', 'First name updated successfully!');
}

public function updateLastName(Request $request)
{
    $user = Auth::user();
    $user->lastt_name = $request->lastt_name;
    $user->save();

    return back()->with('success', 'Last name updated successfully!');
}

public function updateEmail(Request $request)
{
    $user = Auth::user();
    $user->email = $request->email;
    $user->save();

    return back()->with('success', 'Email updated successfully!');
}


public function resetPassword(Request $request)
{
    $user = Auth::user();
    $user->password = Hash::make($request->new_password);  
    $user->save();

    return back()->with('success', 'Password reset successfully!');
}
}
