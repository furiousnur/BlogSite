<?php

namespace App;
use App\Comment;
use App\User;
use App\Category;
use App\Tag;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function tags(){
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function favorite_to_users(){
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', 1);
    }

    public function scopeStatus($query)
    {
        return $query->where('status', 1);
    }
}
