<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Support\Facades\DB; // Use the DB facade
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


    
    public function getHomePagePosts(Request $request)    
    {
        if ($request->query('mine') == 'true') {  //if mine is true
            $posts = Post::where('user_id', auth()->id())->get();  //get posts of user only, it will check if user_id is same as logged in user and will get them
        } else {
            $posts = Post::all();  //get all
        }

        return view('home', compact('posts'));
    }
    public function toggleLikePost($id)
    {
        $user = auth()->user();  //get current user
        $like = DB::table('likes')->where('post_id', $id)->where('user_id', $user->user_id);  //check if user already liked the post or not yet

        if ($like->exists()) {  //if yes, unlike so remove like from table
            $like->delete();
        } else {
            DB::table('likes')->insert([  //if not add to it user id and post id
                'post_id' => $id,
                'user_id' => $user->user_id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        return back();  //go back
    }
}