<?php

namespace App;


use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Template extends Model
{
    protected $fillable = ['source_id', 'name', 'description', 'url', 'resources', 'active'];

    protected $templateDisk = 'local';

    /**
     * Checks if this template is currently in use.
     */
    public function isActive() {
        return $this->active === 'Y';
    }



    /**
     * Adds "template_directory" attribute to the model.
     * 
     */
    public function getTemplateDirectoryAttribute()
    {
        return 'templates/' . $this->name;
    }



    /**
     * Creates the template directory under /resources/views/templates folder.
     */
    public function createTemplateDirectory()
    {
        Storage::disk($this->templateDisk)->makeDirectory($this->template_directory);
    }



    /**
     * Lists all the files available under the template folder
     * along with the metadata information of those files
     */
    public function getFiles ()
    {
        $fileNames = Storage::disk($this->templateDisk)->files($this->template_directory);
        
        $files = [];
        foreach($fileNames as $name) {
            $files[] = [
                "name" => $name,
                "size" => Storage::disk($this->templateDisk)->size($name),
                "updated" => \Carbon\Carbon::createFromTimestamp(
                        Storage::disk($this->templateDisk)->lastModified($name)
                )->format('d-M-Y H:i:s'),
                "basename" => basename($name),
                "dynamic" => ( substr_compare($name, '.blade.php', -10) === 0 ),
            ];
        }

        return $files;
    }



    /**
     * Returns the contents of standard template files based on the file type
     */
    public function getBladeContent($type)
    {
        $fileName = $this->template_directory . '/' . $type . '.blade.php';
        return $this->getFileContent ($fileName);
    }



    /**
     * Returns the contents of non-standard template files
     */
    public function getOtherContent($fileName)
    {
        $fileName = $this->template_directory . '/' . $fileName;
        return $this->getFileContent ($fileName);
    }


    
    /**
     * Saves the template file of provided type with the 
     * supplied content. If the file already exists, it
     * will be overwritten with the content.
     */
    public function setBladeContent($type, $content)
    {
        $fileName = $this->template_directory . '/' . $type . '.blade.php';
        return $this->setFileContent ($fileName, $content);
    }



    /**
     * Saves the supplied content with the file name under the
     * template directory. If the file is present, it will be
     * overwritten. This method is generally used to save the 
     * non-standard files or static files.
     */
    public function setOtherContent ($fileName, $content)
    {
        $fileName = $this->template_directory . '/' . $fileName;
        return $this->setFileContent ($fileName, $content);
    }



    /**
     * Retrieves a template file by name. If the file is not
     * present, empty contents will be returned.
     */
    public function getFileContent ($fileName)
    {
        if (Storage::disk($this->templateDisk)->exists($fileName)) {
            return Storage::disk($this->templateDisk)->get($fileName);
        }
        else {
            return '';
        }
    }



    /**
     * Saves a template file with the supplied content. 
     */
    public function setFileContent ($fileName, $content)
    {
        
        return Storage::disk($this->templateDisk)->put($fileName, $content);
        
    }



    /**
     * Sets the current template as the default template. If
     * there is any other template set as default currently, 
     * that template will be automatically unloaded.
     */
    public function setDefault() 
    {
        $thisTemplate = $this;

        DB::transaction(function() use ($thisTemplate) {
    
            $activeTemplate = Template::where('active', 'Y')->first();

            optional($activeTemplate)->inactivate();

            $thisTemplate->activate();
        });
    }

    

    /**
     * Activates the current template.
     */
    public function activate()
    {
        $files = $this->getFiles();

        $bladeFiles = array_filter($files, function ($item) {
            return $item['dynamic'] === true;
        });

        $staticFiles = array_filter($files, function ($item) {
            return $item['dynamic'] === false;
        });

        $this->copyDynamicFilesToViews($bladeFiles);

        $this->copyStaticFilesToPublic($staticFiles);

        $this->active = 'Y';

        $this->save();
    }



    /**
     * Inactivates the current template.
     */
    public function inactivate()
    {
        $files = $this->getFiles();

        $staticFiles = array_filter($files, function ($item) {
            return $item['dynamic'] === false;
        });

        array_map(function ($file) {

            $this->deleteStaticFileIfExists($file);
            
        }, $staticFiles);

        $this->active = 'N';

        $this->save();
    }



    /**
     * Removes the template directory and 
     * all the template files permanently.
     */
    public function removeFiles()
    {
        return Storage::disk($this->templateDisk)->deleteDirectory($this->template_directory);
    }
    


    /**
     * Copy the dynamic files (blade.php) from the template
     * directory to the views directory.
     */
    private function copyDynamicFilesToViews ($files)
    {   
        
        foreach ($files as $file) 
        {
            $this->deleteDynamicFileIfExists ($file);

            $this->streamCopy($this->templateDisk, $file['name'], 'resources', 'views/' . $file['basename']);
        }

    }



    /**
     * Copies the static files from the template directory
     * to the public directory.
     */
    private function copyStaticFilesToPublic ($files)
    {   
        foreach ($files as $file) 
        {
            $this->deleteStaticFileIfExists($file);

            $this->streamCopy($this->templateDisk, $file['name'], 'public', $file['basename']);

        }
    }



    /**
     * Deletes any static file related to this template
     * from the public directory.
     */
    private function deleteStaticFileIfExists ($file)
    {
        if (Storage::disk('public')->exists($file['basename'])) {
            Storage::disk('public')->delete($file['basename']);
        }
    }



    /**
     * Deletes any dynamic file (blade.php) from the views directory
     */
    private function deleteDynamicFileIfExists ($file) 
    {
        if (Storage::disk('resources')->exists('views/' . $file['basename'])) {
            Storage::disk('resources')->delete('views/' . $file['basename']);
        }
    }



    /**
     * Copy a file from  a specific location to the other location 
     * across disks using stream copy method.
     */
    private function streamCopy ($sourceDisk, $sourceFile, $targetDisk, $targetFile)
    {
        Storage::disk($targetDisk)->writeStream(
            $targetFile, 
            Storage::disk($sourceDisk)->readStream($sourceFile)
        );
    }
    
}
