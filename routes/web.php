<?php

use App\Http\Controllers\AuthManager;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {return view('signin');})->name('signin');

Route::post('/signup', [AuthManager::class, 'signupPost'])->name('signup.post');
Route::post('/signin', [AuthManager::class, 'signinPost'])->name('signin.post');

Route::get('/home', function () {return view('home');})->name('home');
Route::get('/logout', function () {return view('logout');})->name('logout');
Route::get('/admin', function () {return view('admin');})->name('admin');