<?php

namespace App\Http\Controllers;

use App\Models\User;


class UserController extends Controller
{
    // UserController.php

public function index()
{
    $users = User::all(); // Fetch all users from the database
    return view('admin', compact('users')); // Pass users to the view
}

}
