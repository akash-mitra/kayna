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
 * Dynamically configures the mail settings
 */
// function setMailConfig()
// {
//     $service = param('mail_service');

//     dump ('received service = ' . $service);

//     if ($service === 'google') {

//         Config::set('mail.driver', 'smtp');
//         Config::set('mail.host', 'smtp.gmail.com');
//         Config::set('mail.port', '587');
//         Config::set('mail.from', [
//             'address' => param('mail_username'),
//             'name' => alt(param('mail_name'), param('sitename'))
//         ]);
//         Config::set('mail.username', param('mail_username'));
//         Config::set('mail.password', decrypt(param('mail_password')));    
//         Config::set('mail.encryption', 'tls');

//         dump(Config::get('mail.host'));
//         dump(Config::get('mail.password'));

//         return;
//     }
    

//     if ($service === 'smtp') {

//         $driver = alt(param('mail_driver'), 'smtp');
//         $host = param('mail_host');
//         $port = alt(param('mail_port'), '587');
//         $from = [
//             'address' => param('mail_username'),
//             'name' => alt(param('mail_name'), param('sitename'))
//         ];
//         $username = param('mail_username');
//         $password = param('mail_password');
//         $encryption = alt(param('mail_encryption'), 'tls');
        
//         Config::set('mail.driver', $driver);
//         Config::set('mail.host', $host);
//         Config::set('mail.port', $port);
//         Config::set('mail.from', $from);
//         Config::set('mail.username', $username);
//         Config::set('mail.password', $password);    
//         Config::set('mail.encryption', $encryption);

//         return;
//     }    
// }


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

