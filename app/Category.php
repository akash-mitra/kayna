<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'description', 'parent_id'];
    
    protected $appends = ['url', 'ago'];

    public function pages()
    {
        return $this->hasMany('App\Page');
    }


    public function getUrlAttribute()
    {
        return url('categories/' . $this->id . '/' . str_slug($this->name));
    }

    public function getAgoAttribute()
    {
        
        return empty($this->updated_at)? null : $this->updated_at->diffForHumans();
    }

    public function parent()
    {
        return $this->belongsTo('App\Category', 'parent_id')->withDefault();
    }
}
