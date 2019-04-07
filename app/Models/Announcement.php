<?php

namespace App\Models;

use App\User;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->orderBy('created_at', 'desc');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function commented()
    {
        return in_array($this->user->id, $this->comments->pluck('user_id')->toArray());
    }

    public function liked()
    {
        return in_array($this->user->id, $this->likes->pluck('user_id')->toArray());
    }

    public function isOwner()
    {
        $ids = auth()->user()->announcementIds();

        return in_array($this->id, $ids);
    }
}
