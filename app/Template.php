<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $fillable = ['name', 'body'];

    protected $append = ['used_in'];

    public function getUsedInAttribute()
    {
        return DB::table('content_type_templates')->where('template_id', $this->id)->pluck('type')->toArray();
    }
    // public function
}
