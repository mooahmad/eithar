<?php

namespace App\Http\Services\Adminstrator\ProviderModule\ClassesProvider;


use App\Helpers\Utilities;
use App\Models\Provider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;

class ProviderClass
{

    public static function createOrUpdate(Provider $provider, $request, $isCreate = true)
    {
        $provider->currency_id = $request->input('currency_id');
        $provider->price = $request->input('price');
        $provider->visit_duration = $request->input('visit_duration');
        $provider->time_before_next_visit = $request->input('time_before_next_visit');
        $provider->expiry_date = Carbon::parse($request->input('expire_date'))->format('Y-m-d H:m:s');
        $provider->is_active = $request->input('is_active');
        if ($isCreate)
            $provider->added_by = Auth::id();
        return $provider->save();
    }

    /**
     * @param Request $request
     * @param $fileName
     * @param $path
     * @param service $provider
     * @return mixed
     */
    public static function uploadImage(Request $request, $fileName, $path, Provider $provider, $fieldName)
    {
        if ($request->hasFile($fileName)) {
            $isValidImage = Utilities::validateImage($request, $fileName);
            if (!$isValidImage)
                return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                                                     new MessageBag([
                                                                        "message" => __('errors.errorUploadAvatar')
                                                                    ]));
            $isUploaded = Utilities::UploadImage($request->file($fileName), $path);
            if (!$isUploaded)
                return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                                                     new MessageBag([
                                                                        "message" => __('errors.errorUploadAvatar')
                                                                    ]));
            Utilities::DeleteImage($provider->{$fieldName});
            $provider->{$fieldName} = $isUploaded;
            if (!$provider->save())
                return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                                                     new MessageBag([
                                                                        "message" => __('errors.errorUploadAvatar')
                                                                    ]));
            return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));
        }
        return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));
    }

}