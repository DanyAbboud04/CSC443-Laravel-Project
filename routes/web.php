<?php

use App\Http\Controllers\AuthManager;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\PostController; 
use App\Http\Controllers\ReplyController; 
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminCheck;


Route::get('/', function () {return view('signin');})->name('signin'); //route for url / return signin view

//login
Route::post('/signup', [AuthManager::class, 'signupPost'])->name('signup.post');  //post route for  /signup call method signupPost in authmanager where we are creating user account
Route::post('/signin', [AuthManager::class, 'signinPost'])->name('signin.post'); //post route for  /signin call method signinPost in authmanager where we are checking if user account is valid, or admin

Route::middleware([AdminCheck::class])->group(function () {
    Route::get('/admin', function () { return view('admin'); })->name('admin');
    Route::get('/admin', [AuthManager::class, 'getAdminPostsAndUsers'])->name('admin');
    Route::post('/toggle-user-status/{id}', [AuthManager::class, 'toggleUserStatus'])->name('toggle-user-status');
    Route::delete('/delete-guest/{id}', [AuthManager::class, 'deleteGuest'])->name('delete-guest');
});
//enter as guest
Route::get('/enter-as-guest', function (Request $request) {  //creating guest account for user so he can enter as guest and check posts
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

    return redirect()->route('home.view');  // Redirect to home page
});

//show home view and send info for view
Route::get('/home/view', function () {return view('home');})->name('home.view');  //route la /home/view, return home page view
Route::get('/home/view', [PostController::class, 'getHomePagePosts'])->name('home.view');  //calling getHomePgaePosts mn PostController  to show all posts bl home page

//profile, view and updating
Route::get('/profile/view', function () {return view('profile');})->name('profile.view');   //route la /profile/view, return profle account view
Route::get('/profile/view', [UserController::class, 'getUser'])->name('profile.view');  //getting user info mn usercontroller w calling method getUser  w 
Route::post('/profile/update/firstname', [UserController::class, 'updateFirstName'])->name('update.firstname');  //route takes post method tabaa update/firstname eno mtl update.firstname, bt rouh aal controller tabaa user w bt aayet lal method updateFirstName
Route::post('/profile/update/lastname', [UserController::class, 'updateLastName'])->name('update.lastname');
Route::post('/profile/update/email', [UserController::class, 'updateEmail'])->name('update.email');
Route::post('/profile/update/password', [UserController::class, 'resetPassword'])->name('update.password');


Route::post('/posts', [PostController::class, 'store'])->name('posts.store');  //post route for  /posts call method store in postController where we are creating post ewith user info
Route::post('/editpost/{id}', [PostController::class, 'update'])->name('editpost');  //letting user edit his post if he is user, if id of user = if of post user and calling method update where he will be able to update 
Route::delete('/deletepost/{id}', [PostController::class, 'delete'])->name('deletepost');   ////letting user delete his post if he is user, if id of user = if of post user and calling method delete where he will be able to update 

Route::get('/createpost/view', function () {return view('createpost');})->name('createpost.view'); //route la /createpost/view, return creating post view
Route::get('/createpost/view', [UserController::class, 'getHomeUser'])->name('createpost.view');  //calling gethomeuser mn user controller hek l user fi ychouf his infp

//like/unlike
Route::post('/posts/{id}/toggle-like', [PostController::class, 'toggleLikePost'])->name('posts.toggle-like');//post route to toggle like post with id on post controller

//post replies/delete replies
Route::post('/posts/{postId}/replies', [ReplyController::class, 'storeReply'])->name('replies.store');
Route::delete('/replies/{replyId}', [ReplyController::class, 'deleteReply'])->name('replies.delete')->middleware('auth');



Route::get('/search', [PostController::class, 'search'])->name('posts.search');
Route::get('/sort/{criteria}', [PostController::class, 'sort'])->name('posts.sort');
