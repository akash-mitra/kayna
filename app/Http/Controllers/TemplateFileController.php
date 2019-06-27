<?php

namespace App\Http\Controllers;

use App\Template;
use Illuminate\Http\Request;

class TemplateFileController extends Controller
{
    
    /**
     * Shows a view to edit or create a template file. 
     * This view is used to create both standard and non-standard files.
     */
    public function form (Template $template, $type, Request $request)
    {
        if ($type === 'other') { // non-standard
            
            $fileName = $request->input('filename');

            $content = $template->getOtherContent($fileName);

            return view('admin.templates.file', [
                'template' => $template,
                'type' => $type,
                'filename' => $fileName,
                'content' => $content,
                'extension' => $this->getFileExtension($fileName)
            ]);

        }
        else {

            $content = $template->getBladeContent($type);

            return view('admin.templates.file', [
                'template' => $template,
                'type' => $type,
                'filename' => '',
                'content' => $content,
                'extension' => 'PHP'
            ]);

        }
    }



    /**
     * Saves the contents in a template file. If the template 
     * is in use, it will automatically refresh the template as well.
     */
    public function save (Template $template, $type, Request $request)
    {
        //TODO some kind of validation needs to be here about type etc.
        
        $fileContent = $request->input('data');
        $fileName = $request->input('filename');

        if ($type === 'other') {
            $template->setOtherContent($fileName, $fileContent);
        } else {
            $template->setBladeContent($type, $fileContent);
        }

        if ($template->active === 'Y') $template->activate();
        
        session()->flash('flash', 'Success!');

        return back();
        
    }


    private function getFileExtension ($fileName)
    {
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);

        if (empty($extension)) return 'PHP'; // default

        return strtoupper($extension);
    }
}
