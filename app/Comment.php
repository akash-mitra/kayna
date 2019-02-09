<?php

namespace App;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['body', 'parent_id', 'user_id', 'vote', 'commentable_id', 'commentable_type'];
    protected $appends = ['ago'];
    protected $with = ['replies', 'user']; 

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }


    public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    public function getUserVotedAttribute()
    {
        //return $this->votes->where('user_id', '=', \Auth::id())->votes;

        $authUserVoted = \DB::table('votes')
            ->where('votable_type', 'App\Comment')
            ->where('votable_id', $this->id)
            ->where('user_id', Auth::id())
            ->first();
            
        if(! empty($authUserVoted))    return $authUserVoted->votes;

        return null;
    }

    public function getAgoAttribute()
    {
        return empty($this->updated_at) ? null : $this->updated_at->diffForHumans();
    }
}
