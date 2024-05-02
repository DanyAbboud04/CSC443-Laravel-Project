<?php

use App\Http\Controllers\AuthManager;
use App\Http\Controllers\UserController; 
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {return view('signin');})->name('signin');

Route::post('/signup', [AuthManager::class, 'signupPost'])->name('signup.post');
Route::post('/signin', [AuthManager::class, 'signinPost'])->name('signin.post');

Route::get('/home', function () {return view('home');})->name('home');
Route::get('/logout', function () {return view('logout');})->name('logout');
Route::get('/admin', function () {return view('admin');})->name('admin');


Route::get('/admin', [UserController::class, 'index'])->name('admin');


Route::get('/enter-as-guest', function (Request $request) {
    $guestUser = User::create([
        'first_name' => 'Guest',
        'last_name' => 'User',
        'email' => 'guest' . rand() . '@example.com',  
        'password' => '', 
        'is_admin' => false,
        'is_active' => false,
        'is_guest' => true,  
    ]);

    //log in the user as a guest
    Auth::login($guestUser);

    return redirect()->route('home');  // Redirect to the desired location
});

Route::post('/toggle-user-status/{id}', [AuthManager::class, 'toggleUserStatus'])->name('toggle-user-status'); //route takes post method, takes id tabaa l user w bt rouh aa toggleUserStatus  method bl authmanager class
Route::delete('/delete-guest/{id}', [AuthManager::class, 'deleteGuest'])->name('delete-guest');  //nafs l chi hon bas la delete
