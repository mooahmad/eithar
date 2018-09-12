<?php

namespace App\Http\Services\Adminstrator\ServiceModule\ClassesService;


use App\Helpers\Utilities;
use App\LapCalendar;
use App\Models\Questionnaire;
use App\Models\Service;
use App\Models\ServicesCalendar;
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

    public static function createOrUpdateQuestionnaire(Questionnaire $questionnaire, $request, $serviceId, $isCreate = true)
    {
        $questionnaire->service_id = $serviceId;
        $questionnaire->title_ar = $request->input('title_ar');
        $questionnaire->title_en = $request->input('title_en');
        $questionnaire->subtitle_ar = $request->input('subtitle_ar');
        $questionnaire->subtitle_en = $request->input('subtitle_en');
        $questionnaire->type = $request->input('type');
        $questionnaire->type_description = $request->input('type_description');
        $questionnaire->is_required = $request->input('is_required');
        $questionnaire->options_ar = serialize($request->input('options_ar', ''));
        $questionnaire->options_en = serialize($request->input('options_en', ''));
        $questionnaire->pagination = $request->input('page');
        $questionnaire->order = $request->input('order');
        $questionnaire->rating_symbol = $request->input('symbol', null);
        $questionnaire->rating_levels = $request->input('rating_levels', null);
        return $questionnaire->save();
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

    public static function isExistCalendar($startDate, $endDate, $serviceId, $calendarId = false, $cityID)
    {
        $day = Carbon::parse($startDate)->format('Y-m-d');
        $calendar = ServicesCalendar::where('service_id', $serviceId)
            ->where('city_id', $cityID)
            ->where('start_date', 'like', "%$day%")
            ->where(function ($query) use ($startDate, $endDate) {
                $query->where(function ($query) use ($startDate, $endDate) {
                    $query->where('start_date', '=', $startDate)
                        ->whereRaw('end_date = ' . "'$endDate'");
                })
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '<', $startDate)
                            ->whereRaw('end_date > ' . "'$endDate'");
                    })
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '<', $endDate)
                            ->where('start_date', '>', $startDate)
                            ->whereRaw('end_date > ' . "'$endDate'");
                    })
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '>', $startDate)
                            ->whereRaw('end_date < ' . "'$endDate'");
                    })
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '<', $startDate)
                            ->whereRaw('end_date < ' . "'$endDate'")
                            ->whereRaw('end_date > ' . "'$startDate'");
                    })
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '<', $startDate)
                            ->whereRaw('end_date = ' . "'$endDate'");
                    })
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '>', $startDate)
                            ->whereRaw('end_date = ' . "'$endDate'");
                    })
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '=', $startDate)
                            ->whereRaw('end_date < ' . "'$endDate'");
                    })
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '=', $startDate)
                            ->whereRaw('end_date > ' . "'$endDate'");
                    });
            });
        if ($calendarId) {
            $calendar = $calendar->where('id', '<>', $calendarId);
        }
        $calendar = $calendar->get();
        return !$calendar->isEmpty();
    }

    public static function createOrUpdateCalendar(ServicesCalendar $serviceCalendar, $request, $serviceId, $isCreate = true)
    {
        $serviceCalendar->service_id = $serviceId;
        $serviceCalendar->city_id = $request->input('city_id');
        $serviceCalendar->start_date = $request->input('start_date');
        $serviceCalendar->end_date = $request->input('end_date');
        $serviceCalendar->is_available = $request->input('is_available');
        return $serviceCalendar->save();
    }

    public static function isExistLapCalendar($startDate, $endDate, $calendarId = false, $cityId)
    {
        $day = Carbon::parse($startDate)->format('Y-m-d');
        $calendar = LapCalendar::where('start_date', 'like', "%$day%")
            ->where('city_id', $cityId)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->where(function ($query) use ($startDate, $endDate) {
                    $query->where('start_date', '=', $startDate)
                        ->whereRaw('end_date = ' . "'$endDate'");
                })
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '<', $startDate)
                            ->whereRaw('end_date > ' . "'$endDate'");
                    })
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '<', $endDate)
                            ->where('start_date', '>', $startDate)
                            ->whereRaw('end_date > ' . "'$endDate'");
                    })
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '>', $startDate)
                            ->whereRaw('end_date < ' . "'$endDate'");
                    })
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '<', $startDate)
                            ->whereRaw('end_date < ' . "'$endDate'")
                            ->whereRaw('end_date > ' . "'$startDate'");
                    })
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '<', $startDate)
                            ->whereRaw('end_date = ' . "'$endDate'");
                    })
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '>', $startDate)
                            ->whereRaw('end_date = ' . "'$endDate'");
                    })
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '=', $startDate)
                            ->whereRaw('end_date < ' . "'$endDate'");
                    })
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '=', $startDate)
                            ->whereRaw('end_date > ' . "'$endDate'");
                    });
            });
        if ($calendarId) {
            $calendar = $calendar->where('id', '<>', $calendarId);
        }
        $calendar = $calendar->get();
        return !$calendar->isEmpty();
    }

    public static function createOrUpdateLapCalendar(LapCalendar $lapCalendar, $request, $isCreate = true)
    {
        $lapCalendar->city_id = $request->input('city_id');
        $lapCalendar->start_date = $request->input('start_date');
        $lapCalendar->end_date = $request->input('end_date');
        $lapCalendar->is_available = $request->input('is_available');
        return $lapCalendar->save();
    }


}