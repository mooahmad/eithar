<?php

namespace App\Helpers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\MessageBag;

class Utilities
{
    public static function getValidationError($errorType = null, MessageBag $errorsBag)
    {
        return new ValidationError($errorType, $errorsBag);
    }

    /**
     * this function add and delete image
     *
     * @param $file
     * @param $path
     * @param null $old_image_path
     * @param string $disk
     * @return mixed
     */
    public static function UploadImage($file, $path, $oldImagePath = null, $disk = 'local')
    {
        //Delete old image
        if (!empty($oldImagePath))
            self::DeleteImage($oldImagePath);
        return $file->store($path, $disk);
    }

    /**
     *  this function take image path and cut string by storage as default
     * @param $imagePath
     * @param string $disk
     * @return bool
     */
    public static function DeleteImage($imagePath, $disk = 'local')
    {
        if (!empty($imagePath)) {
            if (Storage::disk($disk)->exists($imagePath)) {
                Storage::disk($disk)->delete($imagePath);
                return true;
            }
        }
        return false;
    }

    public static function validateImage(Request $request, $fileName)
    {
        if (!$request->file($fileName)->isValid())
            return false;
        return true;
    }

    public static function getFileUrl($fullFilePath, $temporaryTimeMinutes = null, $disk = 'local')
    {
        $exists = Storage::disk($disk)->exists($fullFilePath);
        if (!$exists)
            return false;
        if ($temporaryTimeMinutes)
            $url = Storage::temporaryUrl(
                $fullFilePath, now()->addMinutes($temporaryTimeMinutes)
            );
        else
            $url = Storage::url($fullFilePath);
        return URL::to('/') . $url;
    }
}