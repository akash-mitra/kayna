<?php

use App\Module;
use App\Template;
use Illuminate\Support\Facades\Cache;

/**
 * Retrieves the value of the key from parameter table
 *
 * @param String $key
 * @return String
 */
function get_param(String $key)
{
    return Cache::rememberForever($key, function () use ($key) {
        return optional(DB::table('parameters')->where('key', $key)->first())->value;
    });
}

function delete_param(String $key)
{
    Cache::forget($key);
    DB::table('parameters')->where('key', $key)->delete();
}

function set_param(String $key, String $value)
{
    delete_param($key);
    DB::table('parameters')->insert(['key' => $key, 'value' => $value]);
}

/**
 * Gets or sets a parameter value. A parameter value can not be
 * set as null using this function. While setting parameter
 * value, it also removes the old value of the parameter 
 * from the cache. While getting a parameter value, it
 * caches the value if it is not already cached.
 * 
 * @param String $key
 * @param mixed $value
 */
function param(String $key, $value = null)
{
    if ($value === null) {
        return get_param($key);
    }
    return set_param($key, $value);
}




/**
 * Returns an array containing the names of modules
 * that are available under given position name
 *
 * @param String $position
 * @return array
 */
function getModulesforPosition($position)
{
    //TODO cache
    return Module::at($position);
}


function alt($val, $alternate_val)
{
    return empty($val) ? $alternate_val : $val;
}


/**
 * Very experimental function to guess the 
 * first name from the fullname.
 */
function guess_first_name($name)
{
    $name = strtolower($name);

    if (substr($name, 0, 2) === 'mr' 
        || substr($name, 0, 2) === 'ms'
        || substr($name, 0, 4) === 'miss'
        || substr($name, 0, 6) === 'master'
        || substr($name, 0, 5) === 'madam'
        || substr($name, 0, 2) === 'dr'
        || substr($name, 0, 4) === 'prof'
        || substr($name, 0, 4) === 'cap.'
        || substr($name, 0, 4) === 'maj.'

    ) return ucfirst($name);

    return ucfirst(explode(' ', str_replace(['.', '-', '_'], ' ', $name))[0]);
}

