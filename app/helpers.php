<?php

use App\ContentTypeTemplate;

function getApplicableModulesFor($position)
{
    class Module
    {
        public $view;
        public $script;

        public function __construct($module)
        {
            $this->view = 'modules.' . $module;
            $this->script = $module . '.js';
        }
    }

    return [new Module('mod2'), new Module('mod1')];
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
