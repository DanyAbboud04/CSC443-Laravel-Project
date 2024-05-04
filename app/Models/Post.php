<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Notifications\Notifiable; 

class Post extends Model
{
    use HasFactory, Notifiable; 

    protected $primaryKey = 'post_id'; 
    protected $table = 'posts';

    protected $fillable = [ 
        'user_id', // foreign key
        'title',
        'description',
        'image',
        'author'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id'); // Defines a many-to-one relationship with the User model.
    }

}
