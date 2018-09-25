<?php

namespace App\Http\Services\Adminstrator\SettingsModule\ClassesSettings;

use App\Helpers\Utilities;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;

class SettingsClass
{

    public static function update(Settings $settings, $mobileNumber, $whatsAppNumber)
    {
        $settings->customer_banner_path = $mobileNumber;
        $settings->customer_banner_path = $whatsAppNumber;
        return $settings->save();
    }

    public static function uploadImage(Request $request, $fileName, $path, Settings $settings, $fieldName)
    {
        if ($request->hasFile($fileName)) {
            $isValidImage = Utilities::validateImage($request, $fileName);
            if (!$isValidImage)
                return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                    new MessageBag([
                        "message" => trans('errors.errorUploadAvatar')
                    ]));
            $isUploaded = Utilities::uploadFile($request->file($fileName), $path);
            if (!$isUploaded)
                return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                    new MessageBag([
                        "message" => trans('errors.errorUploadAvatar')
                    ]));
            Utilities::DeleteFile($settings->{$fieldName});
            $settings->{$fieldName} = $isUploaded;
            if (!$settings->save())
                return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                    new MessageBag([
                        "message" => trans('errors.errorUploadAvatar')
                    ]));
            return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));
        }
        return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));
    }

}