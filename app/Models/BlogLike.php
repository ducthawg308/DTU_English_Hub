<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogLike extends Model
{
    protected $table = 'blog_likes';
    protected $fillable = ['user_id', 'blog_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}