<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = ['name', 'type', 'size', 'storage', 'path'];
    protected $appends = ['url'];
    
    // Static Global Variables
    protected static $allowedExtensions = ['jpeg', 'jpg', 'png', 'bmp', 'gif'];
    protected static $maxSize = 10; //megabytes
    protected static $visibility = 'public';

    /**
     * directoryPath is only applicable for cloud storage.
     * For example, in case of s3 this is actually the bucket name.
     */
    protected static $directoryPath = null;


    protected static $subDirectoryPath = 'media';
    

    /** 
     * Appends an "url" attribute with the model  
     **/
    public function getUrlAttribute()
    {
        //return ($this->storage === 'public' ? '/' : '') . $this->path;

        if ($this->storage === 'public') {
            return '/storage/' . $this->path;
        }
        if ($this->storage === 's3') {
            return 'https://'. $this->directoryPath . '.s3.amazonaws.com/'  . $this->path;
        }
    }


    /**
     * Stores the given file with given name.
     * If the parameter "register" is set to true (by default), the media
     * file information will also be written in the media table in database.
     * If this flag is set to false, the file will be stored in the disk only.
     */
    public static function store($file, $name, $register = true)
    {
        try {
            $sizeInBytes = $file->getClientSize(); // bytes
            self::_checkFileError($file, $sizeInBytes);
            $storageType = self::getStorageType();
            
            $path = Storage::disk($storageType)->putFile(self::$subDirectoryPath, $file, self::$visibility);
            
            $media = new Media([    
                'name' => isset($name) ? $name : $file->getClientOriginalName(),
                'type' => $file->guessExtension(), // $uri_detail['extension'],
                'size' => round($sizeInBytes / 1024, 2), // killobytes
                'path' => empty(self::$directoryPath) ? $path : self::$directoryPath . '/' . $path,
                'storage' => $storageType,
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ]);
            
            if ($register) $media->save();

            return $media;

        } catch (Exception $e) {
            if (Storage::disk($storageType)->exists($path)) {
                Storage::disk($storageType)->delete($path);
            }
            Media::where('id', $id)->delete();
            throw $e;
        }
    }


    public static function destroy($media)
    {
        return self::_destroy($media);
    }

    public static function destroyByFileName($filename)
    {
        $media = Media::where('path', 'like', '%' . $filename)->first();

        return self::_destroy($media);
    }


    public static function _destroy($media)
    {
        if ($media->storage === 'public') {
            Storage::disk('public')->delete($media->path);
        }

        if ($media->storage === 's3') {
            $path_array = explode('/', $media->path);
            $bucket = array_shift($path_array); // gets the bucket name
            $path = implode('/', $path_array);
            
            self::setS3StorageParameters(
                param('storage_s3_key'),
                param('storage_s3_secret'),
                param('storage_s3_region'),
                $bucket
            );
            
            Storage::disk('s3')->delete($path);
        }

        $media->delete();

        return $media;
    }


    


    private static function getStorageType()
    {
        if (param('storage_s3_active') === 'yes') {
            self::setS3StorageParameters(
                param('storage_s3_key'),
                param('storage_s3_secret'),
                param('storage_s3_region'),
                param('storage_s3_bucket')
            );
            return 's3';
        }

        return 'public';
    }


    private static function setS3StorageParameters($key, $secret, $region, $bucket)
    {
        Config::set('filesystems.disks.s3.key', $key);
        Config::set('filesystems.disks.s3.secret', $secret);
        Config::set('filesystems.disks.s3.region', $region);
        Config::set('filesystems.disks.s3.bucket', $bucket);
        self::$directoryPath = $bucket;
    }


    public static function _checkFileError($file, $sizeInBytes)
    {

        if (!isset($file)) {
            abort(400, 'File not uploaded');
        }

        if (!in_array($file->guessExtension(), self::$allowedExtensions)) {
            abort(400, 'Unallowed file type error');
        }

        
        if ($sizeInBytes > (self::$maxSize * 1024 * 1024) || $sizeInBytes <= 0) {
            abort(400, 'File size error');
        }
    }
}
