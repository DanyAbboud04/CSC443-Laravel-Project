<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\User;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(Request $request)  //creating new post with post info and adding image in public folder
    {
        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->user_id = $request->user_id;  
        $post->author = $request->first_name . ' ' . $request->last_name;

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('images'), $imageName);
            $post->image = 'images/'.$imageName; // Store the image file path
        }

        $post->save();
    
        return redirect()->route('home.view');
    }

    public function update(Request $request, $id)  //user edit title and description for a post
{   

    $post = Post::findOrFail($id);
    $post->title = $request->input('title');
    $post->description = $request->input('description');
    // Update any other fields as needed
    $post->save();

    return redirect()->back()->with('success', 'Post updated successfully');
    
}

public function delete($id)   //deleteing a post
    {
        // Find the post by ID
        $post = Post::findOrFail($id);

        // Check if the authenticated user is the author of the post
            $post->delete();

            // Redirect back with success message
            return redirect()->back()->with('success', 'Post deleted successfully');
    }


public function getHomePagePosts()    //sending all posts for home view
{
    $posts = Post::all(); // Get all posts from the database
    // Always pass both 'user' and 'posts' to the home view
    return view('home', compact('posts'));
}

}
