<?php

namespace App\Http\Services\Adminstrator\ServiceModule\ClassesService;


use App\Helpers\Utilities;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;

class ServiceClass
{

    public static function createOrUpdate(Service $service, $request, $isCreate = true)
    {
        $service->category_id = $request->input('parent_cat');
        $service->country_id = $request->input('country_id');
        $service->currency_id = $request->input('currency_id');
        $service->type = $request->input('type');
        $service->type_desc = $request->input('type_desc');
        $service->name_ar = $request->input('name_ar');
        $service->name_en = $request->input('name_en');
        $service->desc_ar = $request->input('desc_ar');
        $service->desc_en = $request->input('desc_en');
        $service->benefits_ar = $request->input('benefits_ar');
        $service->benefits_en = $request->input('benefits_en');
        $service->price = $request->input('price');
        $service->visit_duration = $request->input('visit_duration');
        $service->time_before_next_visit = $request->input('time_before_next_visit');
        $service->expiry_date = Carbon::parse($request->input('expire_date'))->format('Y-m-d H:m:s');
        $service->is_active_service = $request->input('is_active');
        $service->appear_on_website = $request->input('appear_on_website');
        $service->profile_video_path = $request->input('video');
        if ($isCreate)
            $service->added_by = Auth::id();
        return $service->save();
    }

    /**
     * @param Request $request
     * @param $fileName
     * @param $path
     * @param service $service
     * @return mixed
     */
    public static function uploadImage(Request $request, $fileName, $path, Service $service, $fieldName)
    {
        if ($request->hasFile($fileName)) {
            $isValidImage = Utilities::validateImage($request, $fileName);
            if (!$isValidImage)
                return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                                                     new MessageBag([
                                                                        "message" => trans('errors.errorUploadAvatar')
                                                                    ]));
            $isUploaded = Utilities::UploadImage($request->file($fileName), $path);
            if (!$isUploaded)
                return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                                                     new MessageBag([
                                                                        "message" => trans('errors.errorUploadAvatar')
                                                                    ]));
            Utilities::DeleteImage($service->{$fieldName});
            $service->{$fieldName} = $isUploaded;
            if (!$service->save())
                return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                                                     new MessageBag([
                                                                        "message" => trans('errors.errorUploadAvatar')
                                                                    ]));
            return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));
        }
        return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));
    }

}