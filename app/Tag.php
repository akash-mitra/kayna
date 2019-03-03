<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name', 'description'];
    protected $appends = ['url', 'ago'];

    public function pages()
    {
        return $this->morphedByMany(\App\Page::class, 'taggable');
    }

    public function getUrlAttribute()
    {
        return url('tags/' . $this->id . '/' . Str::slug($this->name));
    }

    public function getAgoAttribute()
    {
        return $this->updated_at->diffForHumans();
    }
}
