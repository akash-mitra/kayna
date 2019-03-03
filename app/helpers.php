<?php

use App\Module;
use App\ContentTypeTemplate;
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
        return DB::table('parameters')->where('key', $key)->first()->value;
    });
}

function param(String $key)
{
    return get_param($key);
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
    return ContentTypeTemplate::for($contentType);
}

function compiledView(string $contentType, array $data)
{
    $template = getTemplate($contentType);

    $compiledTemplate = Blade::compileString($template);

    //TODO
    // for each content type, cache the compiledTemplate

    return render($compiledTemplate, $data);
}

function render(string $__php, array $__data)
{
    $__data['__env'] = app(\Illuminate\View\Factory::class);

    $obLevel = ob_get_level();
    ob_start();
    extract($__data, EXTR_SKIP);
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
