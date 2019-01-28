<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['category_id', 'user_id', 'title', 'summary', 'metakey', 'metadesc', 'media_url', 'status'];

    protected $appends = ['url', 'ago'];

    public function content()
    {
        return $this->hasOne('App\PageContent');
    }

    public function author()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id')->withDefault([
            'name' => 'Uncategorized',
            'description' => null
        ]);
    }

    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }

    public function getUrlAttribute()
    {
        return url('pages/' . $this->id . '/' . str_slug($this->title));
    }

    public function getAgoAttribute()
    {
        
        return empty($this->updated_at) ? null : $this->updated_at->diffForHumans();
    }
}
