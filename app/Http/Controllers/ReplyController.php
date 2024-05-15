<?php

namespace App\Http\Controllers;
use App\Models\Reply;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function storeReply(Request $request, $postId)
    {    
        //create new reply
        $reply = new Reply();
        $reply->content = $request->content;
        $reply->post_id = $postId;
        $reply->user_id = auth()->id();
        $reply->save();
    
        return back();
    }
}