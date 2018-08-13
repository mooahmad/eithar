<?php

namespace App\Http\Services\Adminstrator\ProviderModule\ClassesProvider;


use App\Helpers\Utilities;
use App\Models\Provider;
use App\Models\ProvidersCalendar;
use App\Models\ProviderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;

class ProviderClass
{

    public static function createOrUpdate(Provider $provider, $request, $isCreate = true)
    {
        $provider->currency_id = $request->input('currency_id');
        $provider->title_ar = $request->input('title_ar');
        $provider->title_en = $request->input('title_en');
        $provider->first_name_ar = $request->input('first_name_ar');
        $provider->first_name_en = $request->input('first_name_en');
        $provider->last_name_ar = $request->input('last_name_ar');
        $provider->last_name_en = $request->input('last_name_en');
        $provider->speciality_area_ar = $request->input('speciality_area_ar');
        $provider->speciality_area_en = $request->input('speciality_area_en');
        $provider->price = $request->input('price');
        $provider->rating = $request->input('rating');
        $provider->about_ar = $request->input('about_ar');
        $provider->about_en = $request->input('about_en');
        $provider->experience_ar = $request->input('experience_ar');
        $provider->experience_en = $request->input('experience_en');
        $provider->education_ar = $request->input('education_ar');
        $provider->education_en = $request->input('education_en');
        $provider->is_active = $request->input('is_active');
        $provider->contract_start_date = $request->input('contract_start_date');
        $provider->contract_expiry_date = $request->input('contract_expiry_date');
        $provider->visit_duration = $request->input('visit_duration');
        $provider->time_before_next_visit = $request->input('time_before_next_visit');
        if ($isCreate)
            $provider->added_by = Auth::id();
        $provider->save();
        self::linkServices($provider, $request);
        return self::linkCities($provider, $request);
    }

    public static function linkServices(Provider $provider, $request)
    {
        $services = $request->input('services');
        return $provider->services()->sync($services);
    }

    public static function linkCities(Provider $provider, $request)
    {
        $cities = $request->input('cities');
        return $provider->cities()->sync($cities);
    }

    public static function createOrUpdateCalendar(ProvidersCalendar $providerCalendar, $request, $providerId, $isCreate = true)
    {
        $providerCalendar->provider_id = $providerId;
        $providerCalendar->start_date = $request->input('start_date');
        $providerCalendar->end_date = $request->input('end_date');
        $providerCalendar->is_available = $request->input('is_available');
        return $providerCalendar->save();
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
                                                                        "message" => trans('errors.errorUploadAvatar')
                                                                    ]));
            $isUploaded = Utilities::UploadImage($request->file($fileName), $path);
            if (!$isUploaded)
                return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                                                     new MessageBag([
                                                                        "message" => trans('errors.errorUploadAvatar')
                                                                    ]));
            Utilities::DeleteImage($provider->{$fieldName});
            $provider->{$fieldName} = $isUploaded;
            if (!$provider->save())
                return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                                                     new MessageBag([
                                                                        "message" => trans('errors.errorUploadAvatar')
                                                                    ]));
            return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));
        }
        return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));
    }

}