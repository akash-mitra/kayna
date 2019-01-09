<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentTypeTemplate extends Model
{
    protected $fillable = ['type', 'template_id'];

    /**
     * Get the template associated with the template type
     *
     * @return void
     */
    public function template()
    {
        return $this->hasOne(Template::class, 'id', 'template_id');
    }

    /**
     * Get the template syntax for a specific content type
     *
     * @param  string $type
     * @return string
     */
    public static function for(string $type)
    {
        return static::with('template')->where('type', $type)->firstOrFail()->template->body;
    }
}
