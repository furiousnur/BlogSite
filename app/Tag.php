<?php

namespace App;
use App\Post;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = [];

    public function posts(){
        return $this->belongsToMany(Post::class)->withTimestamps();
    }
}
