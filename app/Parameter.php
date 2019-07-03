<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    private static $encryptionList = [
        'mail_password'
    ];


    /**
     * Return all the key-value pairs as simple object
     *
     * @return String
     */
    public static function getObject()
    {
        $paramObject = (object) [];
        $paramArray = Parameter::select(['key', 'value'])->get()->toArray();
        
        foreach ($paramArray as $param) {
            $key = $param['key'];
            $paramObject->{$key} = $param['value'];
        }
        return $paramObject;
    }


    /**
     * Encrypts the value if the key is in the encryption list.
     */
    public static function checkForEncryption($key, $value)
    {
        return (in_array($key, self::$encryptionList)? encrypt($value) : $value); 
    }
}
