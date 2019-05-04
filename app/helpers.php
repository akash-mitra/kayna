<?php

use App\Module;
use App\Template;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\Debug\Exception\FatalThrowableError;

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



function getTemplate($contentType)
{
    return Template::where('type', $contentType)->where('active', 'Y')->first()->body;
}

function compiledView(string $contentType, array $data)
{
    $template = getTemplate($contentType);

    $compiledTemplate = Blade::compileString($template);

    //TODO
    // for each content type, cache the compiledTemplate

    return render($compiledTemplate, $data);
}

function render(string $__php, array $page)
{
    // dd($page->title);
    $page['__env'] = app(\Illuminate\View\Factory::class);

    $obLevel = ob_get_level();
    ob_start();
    extract($page, EXTR_SKIP);
    try {
        eval('?' . '>' . $__php);
    } catch (Exception $e) {
        while (ob_get_level() > $obLevel) {
            ob_end_clean();
        }
        throw $e;
    } catch (Throwable $e) {
        while (ob_get_level() > $obLevel) {
            ob_end_clean();
        }
        throw new FatalThrowableError($e);
    }

    return ob_get_clean();
}
