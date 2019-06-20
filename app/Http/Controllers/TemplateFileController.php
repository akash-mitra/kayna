<?php

namespace App\Http\Controllers;

use App\Template;
use Illuminate\Http\Request;

class TemplateFileController extends Controller
{
    
    /**
     * Returns the same template edit form (like edit) but
     * also sends the content of the specific blade file.
     */
    public function form (Template $template, $type)
    {
        $content = $template->getBladeContent($type);

        return view('admin.templates.file', [
            'template' => $template,
            'type' => $type,
            'content' => $content
        ]);
    }


    public function save (Template $template, $type, Request $request)
    {
        //TODO some kind of validation needs to be here
        
        $data = $request->input('data');
        $template->setBladeContent($type, $data);
        return back();
    }
}
