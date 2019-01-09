<?php

namespace App;

use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class media extends Model
{
    protected $fillable = ['name', 'type', 'size', 'storage', 'path'];
    
    // Static Global Variables
    protected static $allowedExtensions = ['jpeg', 'jpg', 'png', 'bmp', 'gif'];
    protected static $maxSize = 10; //megabytes
    protected static $visibility = 'public';
    protected static $subDirectoryPath = 'media'; // 'Media'

    // Storage Type
    protected static $storageType = 'public';

    public static function url($storage, $fileName)
    {
        if ($storage === 'public') return asset($fileName);
    }

    public static function store ($file, $name) {
        try {
  
            $sizeInBytes = $file->getClientSize(); // bytes
            self::_checkFileError ($file, $sizeInBytes);
  
            self::setStorageType();

            $path = Storage::disk(self::$storageType)->putFile(self::$subDirectoryPath, $file, self::$visibility);

            $id = DB::table('media')->insertGetId([
                
                'name' => isset($name) ? $name : $file->getClientOriginalName(),
                'type' => $file->guessExtension(), // $uri_detail['extension'],
                'size' => round($sizeInBytes / 1024, 2), // killobytes
                'path' => $path,
                'storage' => self::$storageType,
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ]);

            return self::url(self::$storageType, $path);

        } 
        catch (Exception $e) {

            if (Storage::disk(self::$storageType)->exists($path)) {
                Storage::disk(self::$storageType)->delete($path);
            }
            Media::where('id', $id)->delete();
            abort(500, $e->getMessage());
        }
    }


    private static function setStorageType ()
    {
        // $storage = Configuration::getConfig('storage');
        // $value = $storage['storage'];

        // if ($value['type'] == 's3') {
        //     self::$storageType = 's3';
        //     \Config::set('filesystems.disks.s3.key', $value['key']);
        //     \Config::set('filesystems.disks.s3.secret', $value['secret']);
        //     \Config::set('filesystems.disks.s3.region', $value['region']);
        //     \Config::set('filesystems.disks.s3.bucket', $value['bucket']);
        // }
        // return true;
    }


    public static function _checkFileError ($file, $sizeInBytes) {

        if (!isset($file))
            abort(400, 'File not uploaded');

        if (!in_array($file->guessExtension(), self::$allowedExtensions))
            abort(400, 'Unallowed file type error');

        
        if ($sizeInBytes > (self::$maxSize * 1024 * 1024) || $sizeInBytes <= 0)
            abort(400, 'File size error');
    }
}
