<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name', 'description'];
    protected $appends = ['url', 'ago'];

    public function pages()
    {
        return $this->morphedByMany('App\Page', 'taggable');
    }

    public function getUrlAttribute()
    {
        return url('tags/' . $this->id . '/' . str_slug($this->name));
    }

    public function getAgoAttribute()
    {
        return $this->updated_at->diffForHumans();
    }
}
