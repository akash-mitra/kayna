<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['category_id', 'user_id', 'title', 'summary', 'metakey', 'metadesc', 'media_url', 'status'];

    protected $appends = ['url', 'ago'];

    public function content()
    {
        return $this->hasOne(\App\PageContent::class);
    }

    public function author()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(\App\Category::class, 'category_id')->withDefault([
            'name' => 'Uncategorized',
            'description' => null
        ]);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function tags()
    {
        return $this->morphToMany(\App\Tag::class, 'taggable');
    }

    public function getUrlAttribute()
    {
        return url('pages/' . $this->id . '/' . Str::slug($this->title));
    }

    public function getAgoAttribute()
    {
        return empty($this->updated_at) ? null : $this->updated_at->diffForHumans();
    }

    public static function props()
    {
        return [
            ['name' => 'title', 'description' => 'Title of the article in the page', 'visibility' => true, 'class' => 'default-page-title', 'placeholder' => ['tag' => 'span', 'text' => 'The Intersteller Journey to the future']],
            ['name' => 'summary', 'description' => 'Short summary about the article', 'visibility' => true, 'class' => 'default-page-summary', 'placeholder' => ['tag' => 'p', 'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']],
            ['name' => 'media_url', 'description' => 'Main media file with the article', 'visibility' => true, 'class' => '', 'placeholder' => ['tag' => 'img', 'src' => 'https://picsum.photos/200/300/?random']],
            ['name' => 'status', 'description' => 'Publication status of the article', 'visibility' => false, 'class' => '', 'placeholder' => ['tag' => 'span', 'text' => 'Draft']],
            ['name' => 'created_at', 'description' => 'Create Date of the page', 'visibility' => true, 'class' => '', 'placeholder' => ['tag' => 'span', 'text' => '2019-01-02 10:47:55']],
            ['name' => 'updated_at', 'description' => 'Last Update Date of the page', 'visibility' => true, 'class' => '', 'placeholder' => ['tag' => 'span', 'text' => '2019-01-02 10:47:55']],
            ['name' => 'ago', 'description' => 'How long ago the page was created or last updated', 'visibility' => true, 'class' => '', 'placeholder' => ['tag' => 'span', 'text' => '1 month ago']],
            ['name' => 'url', 'description' => 'Url of the page', 'visibility' => true, 'class' => '', 'placeholder' => ['tag' => 'a', 'href' => 'url', 'text' => 'http://example.com']],

            ['name' => 'category.name', 'description' => 'Category Name', 'visibility' => true, 'class' => '', 'placeholder' => ['tag' => 'span', 'text' => 'Sci-Fi Movies']],
            ['name' => 'category.url', 'description' => 'URL of the category', 'visibility' => true, 'class' => '', 'placeholder' => ['tag' => 'a', 'href' => 'category.url', 'text' => 'Sci-Fi Movie']],
            ['name' => 'category.id', 'description' => 'Category Id', 'visibility' => false, 'class' => '', 'placeholder' => []],

            ['name' => 'author.name', 'description' => 'Author Name', 'visibility' => true, 'class' => '', 'placeholder' => ['tag' => 'a', 'href' => 'author.url', 'text' => 'Nancy Dew']],
            ['name' => 'author.avatar', 'description' => 'Author Profile Pic', 'visibility' => true, 'class' => '', 'placeholder' => ['tag' => 'img', 'src' => 'https://randomuser.me/api/portraits/med/women/81.jpg']],

            ['name' => 'content.body', 'description' => 'Content of the page', 'visibility' => true, 'class' => 'default-page-content', 'placeholder' => ['tag' => 'div', 'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']]
        ];
    }
}
