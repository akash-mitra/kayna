<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Restriction extends Model
{
    protected $fillable = ['user_type', 'content_type', 'content_id'];
    
    public static function list()
    {
        $sql = 'select r.user_type, r.content_id, r.content_type, p.title page_title, p.id page_id, c.name category_name, c.id category_id from restrictions r left outer join pages p on r.content_type = "page" and r.content_id = p.id left outer join categories c on r.content_type = "category" and r.content_id = c.id';

        return array_map(function ($item) {
            return [
                'content_id' => $item->content_id,
                'content_type' => ucfirst($item->content_type),
                'content_title' => ($item->content_type === 'Page'? $item->page_title : $item->category_name),
                'user_type' => ucfirst($item->user_type),
                'url' => ($item->content_type === 'Page'? '/pages/'.$item->page_id : '/categories/'.$item->category_id)
            ];
        }, DB::select($sql));
    }


    public static function exists($restriction)
    {
        //TODO TO BE CACHED

        return Restriction::where('content_type', $restriction->content_type)->where('content_id', $restriction->content_id)->first();
    }
}
