<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentsPost extends Model
{
    protected $fillable = [
        'comment_text',
        'post_id',
        'user_id',
    ];
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
