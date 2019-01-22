<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    //


    // public static function get($key)
    // {
    //     return Parameter::where('key', $key)->pluck('value')->first();
    // }
    /**
     * Return all the key-value pairs as simple object
     *
     * @return String
     */ 
    public static function getObject()
    {
        $paramObject = (object) [];
        $paramArray = Parameter::select(['key', 'value'])->get()->toArray();
        
        foreach($paramArray as $param) {
            $key = $param['key'];
            $paramObject->{$key} = $param['value'];
        }
        return $paramObject;
    }
}
