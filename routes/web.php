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


Route::get('/admin', [UserController::class, 'index'])->name('admin');   //route takes get method, index  method bl usercontroller class


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

Route::get('/profile', function () {return view('profile');})->name('profile');

Route::get('/profile', [UserController::class, 'getUser'])->name('profile');

Route::post('/profile/update/firstname', [UserController::class, 'updateFirstName'])->name('update.firstname');  //route takes post method tabaa update/firstname eno mtl update.firstname, bt rouh aal ontroller tabaa user w bt aayet lal method updateFirstName
Route::post('/profile/update/lastname', [UserController::class, 'updateLasttName'])->name('update.lastname');
Route::post('/profile/update/email', [UserController::class, 'updateEmail'])->name('update.email');
Route::post('/profile/update/password', [UserController::class, 'resetPassword'])->name('update.password');
