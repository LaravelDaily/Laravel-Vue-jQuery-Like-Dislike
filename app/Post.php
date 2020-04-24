<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'full_text',
        'created_at',
        'updated_at',
    ];

    public function ratings()
    {
        return $this->belongsToMany(User::class, 'post_ratings')->withPivot('type');
    }

    public function likes()
    {
        return $this->ratings()->where('post_ratings.type', 'like');
    }

    public function dislikes()
    {
        return $this->ratings()->where('post_ratings.type', 'dislike');
    }
}
