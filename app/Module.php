<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Module extends Model
{

    protected $fillable = ['name', 'type', 'file', 'position', 'exceptions', 'applicables', 'active'];

    protected $appends = ['file'];

    /**
     * This will return a collection of both custom and pre-built modules 
     *
     * @return @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function allModules() 
    {
        $modules = parent::all();

        // check if comment module present, if not add it
        $commentModule = $modules->filter(function ($module) {
            return $module->type === 'comment';
        });
        if ($commentModule->count() === 0) {
            $modules->push([
                "id" => null,
                "name" => 'comment',
                "type" => 'comment',
                "position" => null,
                "active" => 'N'
            ]);
        }

        return $modules;
    }

    public static function getTypes()
    {
        return ['Custom', 'Related', 'Popular'];
    }
    
    
   

    public static function at($position)
    {
        $modules = DB::table('modules')->where('position', $position)->pluck('name');

        return array_map(function ($name) {
            return 'modules.' . $name;
        }, $modules->toArray());
    }

    public static function storeTemplate($filename, $content)
    {
        return Storage::disk('resources')->put(self::fullFileName($filename), $content);
    }

    public static function getTemplate($filename)
    {
        return Storage::disk('resources')->get(self::fullFileName($filename));
    }


    public static function updateTemplate($oldName, $newName, $content)
    {

        self::removeTemplate($oldName);
        return self::storeTemplate($newName, $content);
    }


    public static function removeTemplate($name)
    {
        return Storage::disk('resources')->delete(self::fullFileName($name));
    }


    public static function fullFileName($filename)
    {
        return 'views/modules/' . $filename . '.blade.php';
    }


    public function getFileAttribute()
    {
        return self::fullFileName($this->name);
    }
}
