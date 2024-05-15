<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = ['content', 'post_id', 'user_id'];

    public function post()// Defines a relationship where a Reply belongs to a Post
    {
        return $this->belongsTo(Post::class, 'post_id', 'post_id');
    }

    public function user()// Defines a relationship where a Reply belongs to a User (author of the reply)
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
