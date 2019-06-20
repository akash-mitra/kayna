<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Template extends Model
{
    protected $fillable = ['source_id', 'name', 'description', 'url', 'resources', 'active'];

    // protected $append = ['used_in'];

    // public function getUsedInAttribute()
    // {
    //     return DB::table('content_type_templates')->where('template_id', $this->id)->pluck('type')->toArray();
    // }

    public function isActive() {
        return $this->active === 'Y';
    }

    /**
     * Creates the template directory under /resources/views/templates folder.
     */
    public function createTemplateDirectory()
    {
        Storage::disk('resources')->makeDirectory($this->template_directory);
    }


    /**
     * Lists all the files available under the template folder
     * along with the metadata information of those files
     */
    public function getFiles ()
    {
        $fileNames = Storage::disk('resources')->files($this->template_directory);
        
        $files = [];
        foreach($fileNames as $name) {
            $files[] = [
                "name" => $name,
                "size" => Storage::disk('resources')->size($name),
                "updated" => \Carbon\Carbon::createFromTimestamp(
                        Storage::disk('resources')->lastModified($name)
                )->format('d-M-Y H:i:s'),
            ];
        }

        return $files;
    }


    public function getBladeContent($type)
    {
        $fileName = $this->template_directory . '/' . $type . '.blade.php';
        return $this->getFileContent ($fileName);
    }


    public function setBladeContent($type, $content)
    {
        $fileName = $this->template_directory . '/' . $type . '.blade.php';
        return $this->setFileContent ($fileName, $content);
    }


    public function getFileContent ($fileName)
    {
        if (Storage::disk('resources')->exists($fileName)) {
            return Storage::disk('resources')->get($fileName);
        }
        else {
            return '';
        }
    }


    public function setFileContent ($fileName, $content)
    {
        // if (Storage::disk('resources')->exists($fileName)) {
            return Storage::disk('resources')->put($fileName, $content);
        // }
        // else {
            // return '';
        // }
    }

    /**
     * Adds "template_directory" attribute to the model.
     * 
     */
    public function getTemplateDirectoryAttribute()
    {
        return 'views/templates/' . $this->name;
    }
    

    //-------------------------------------------------------------------------------------------------------------------------
















    // public static function refreshViewTemplate($type, $content)
    // {
    //     $viewFileName = 'views/' . $type . '.blade.php';

    //     if (Storage::disk('resources')->exists($viewFileName)) {
    //         Storage::disk('resources')->delete($viewFileName);
    //     }

    //     Storage::disk('resources')->put($viewFileName, $content);
    // }


    /**
     * Creates a fileName from the template name and template types.
     * 
     * Removes all special characters and space and replace them 
     * with underscore only.
     */
    // public static function getFileFromTemplateName($name, $type) {
    //     return 'templates'
    //         . '/' 
    //         . $type 
    //         . '/'
    //         . preg_replace('/[^A-Z0-9]+/i', '_', strtolower($name)) 
    //         . '.blade.php';
    // }

    // public static function buildFromFrame(array $rows, array $head, String $type)
    // {
    //     $body = '<!DOCTYPE html>' . PHP_EOL;
    //     $body .= '<html lang="' . self::getHeader($head, 'lang') . '">' . PHP_EOL;
    //     $body .= '<head>' . PHP_EOL;
    //     $body .= "\t" . '<meta charset="' . self::getHeader($head, 'charset') . '">' . PHP_EOL;
    //     $body .= "\t" . '<meta name="viewport" content="width=device-width, initial-scale=1.0">' . PHP_EOL;
    //     $body .= "\t" . '<meta http-equiv="X-UA-Compatible" content="ie=edge">' . PHP_EOL;
    //     $body .= "\t" . '<meta name="csrf-token" content="' . self::getHeader($head, 'csrf-token') . '">' . PHP_EOL;
    //     $body .= "\t" . '<link rel="stylesheet" href="' . self::getHeader($head, 'css')  . '">' . PHP_EOL;
    //     $body .= "\t" . '<link rel="stylesheet" href="' . self::getHeader($head, 'template-css') . '">' . PHP_EOL;
    //     $body .= "\t" . '<title></title>' . PHP_EOL;
    //     $body .= '</head>' . PHP_EOL;
    //     $body .= '<body>' . PHP_EOL;

    //     foreach ($rows as $row) {
    //         $body .= "\t" . '<div class="' . $row->class . '">' . PHP_EOL;
    //         foreach ($row->cols as $col) {
    //             $body .= "\t\t" . '<div class="' . $col->class . '">' . PHP_EOL;

    //             foreach ($col->positions as $position) {
    //                 $body .= "\t\t\t" . '<div class="' . $position->class . '">' . PHP_EOL;
    //                 $body .= "\t\t\t\t" . '@foreach(getModulesforPosition("' . $position->name . '") as $module)' . PHP_EOL;
    //                 $body .= "\t\t\t\t\t" . '@includeIf($module)' . PHP_EOL;
    //                 $body .= "\t\t\t\t" . '@endforeach' . PHP_EOL;

    //                 foreach ($position->items as $item) {
    //                     if ($item->placeholder->tag === 'span') {
    //                         $body .= "\t\t\t\t" . '<span class="' . $item->class . '">' . self::p($item->name, $type) . '</span>' . PHP_EOL;
    //                     }
    //                     if ($item->placeholder->tag === 'p') {
    //                         $body .= "\t\t\t\t" . '<p class="' . $item->class . '">' . self::p($item->name, $type) . '</p>' . PHP_EOL;
    //                     }
    //                     if ($item->placeholder->tag === 'div') {
    //                         $body .= "\t\t\t\t" . '<div class="' . $item->class . '">' . self::p($item->name, $type) . '</div>' . PHP_EOL;
    //                     }
    //                     if ($item->placeholder->tag === 'a') {
    //                         $body .= "\t\t\t\t" . '<a class="' . $item->class . '" href="' . self::p($item->placeholder->href, $type) . '">' . self::p($item->name, $type) . '</a>' . PHP_EOL;
    //                     }
    //                     if ($item->placeholder->tag === 'img') {
    //                         $body .= "\t\t\t\t" . '<img class="' . $item->class . '" src="' . self::p($item->name, $type) . '" />' . PHP_EOL;
    //                     }
    //                 }

    //                 $body .= "\t\t\t" . '</div>' . PHP_EOL;
    //             }
    //             $body .= "\t\t" . '</div>' . PHP_EOL;
    //         }
    //         $body .= "\t" . '</div>' . PHP_EOL;
    //     }
    //     $body .= "\t" . '<script src="' . self::getHeader($head, 'js')  . '"></script>' . PHP_EOL;
    //     $body .= '</body>' . PHP_EOL;
    //     $body .= '</html>';

    //     return $body;
    // }

    // public static function getHeader(array $props, String $prop)
    // {
    //     $val = array_filter($props, function ($item) use ($prop) {
    //         if ($item->prop === $prop) {
    //             return true;
    //         }
    //         return false;
    //     });

    //     return array_values($val)[0]->value;
    // }

    // public static function p($var, $type)
    // {
    //     // phpcise it by replacing all '.' with '->'
    //     // then laravelise it with blade syntax
    //     //
    //     // example,
    //     // input > category.name
    //     // output > $category['name']
    //     //
    //     // input > user.address.zip
    //     // output > $user['address']['zip']
    //     //

    //     $attributes = explode(".", $var);
    //     $initial = '$' . $attributes[0];
    //     $brackets = '';
    //     for ($i = 1; $i < count($attributes); $i++) {
    //         $brackets .= "['" . $attributes[$i] . "']";
    //     }
    //     return '{!!' . $initial . $brackets . '!!}';

    //     // return "{{ $" . $type . "['" . str_replace(".", "']['", $var) . "'] }}";
    // }
}
