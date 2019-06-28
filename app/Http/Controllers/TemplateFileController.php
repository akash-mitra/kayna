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

            $this->stopDynamicFileAddition($fileName);

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
        //TODO validation for "type" and "data"

        $fileContent = $request->input('data');

        if ($type === 'other') {
            
            $fileName = $request->input('filename');
            
            $this->stopDynamicFileAddition($fileName);

            $template->setOtherContent($fileName, $fileContent);
            
            
        } else {

            $template->setBladeContent($type, $fileContent);
        }


        // refresh the template after changes if the template is in use
        if ($template->isActive()) $template->activate();
        
        session()->flash('flash', 'Success!');

        return back();
        
    }



    /**
     * This function stops php files to be added as static file
     */
    private function stopDynamicFileAddition ($filename)
    {
        if (substr_compare($filename, '.php', -4) === 0) {
            abort (400, 'Dynamic files (such as php files) are not allowed to be added.');
        }
    }


    private function getFileExtension ($fileName)
    {
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);

        if (empty($extension)) return 'TXT'; // default

        return strtoupper($extension);
    }
}
