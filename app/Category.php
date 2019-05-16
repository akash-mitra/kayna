<?php

namespace App;

use App\Page;
use App\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'description', 'parent_id'];

    protected $appends = ['url',  'created_ago', 'updated_ago'];

    public function parent()
    {
        return $this->belongsTo(\App\Category::class, 'parent_id')->withDefault();
    }
    
    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function getUrlAttribute()
    {
        return url('categories/' . $this->id . '/' . Str::slug($this->name));
    }

    public function getCreatedAgoAttribute()
    {
        return empty($this->created_at)? null : $this->created_at->diffForHumans();
    }

    public function getUpdatedAgoAttribute()
    {
        return empty($this->updated_at)? null : $this->updated_at->diffForHumans();
    }

    

}
