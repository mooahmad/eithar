<?php

namespace App\Http\Services\Adminstrator\ServiceModule\ClassesService;


use App\Helpers\Utilities;
use App\LapCalendar;
use App\Models\MedicalReports;
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
        $no_of_visits = $request->input('number_of_visits', null);
        if ($no_of_visits == null)
            $no_of_visits = 0;
        $service->no_of_visits = $no_of_visits;
        $visits_per_week = $request->input('number_of_visits_per_week', null);
        if ($visits_per_week == null)
            $visits_per_week = 0;
        $service->visits_per_week = $visits_per_week;
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

    public static function createOrUpdateMedicalReport(MedicalReports $medicalReport, $request, $serviceId)
    {
        $medicalReport->service_id = $serviceId;
        $medicalReport->title_ar = $request->input('title_ar');
        $medicalReport->title_en = $request->input('title_en');
        $medicalReport->type = $request->input('type');
        $medicalReport->type_description = $request->input('type_description');
        $medicalReport->is_required = $request->input('is_required');
        $medicalReport->options_ar = serialize($request->input('options_ar', ''));
        $medicalReport->options_en = serialize($request->input('options_en', ''));
        $medicalReport->pagination = $request->input('page');
        $medicalReport->order = $request->input('order');
        return $medicalReport->save();
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
            $isUploaded = Utilities::uploadFile($request->file($fileName), $path);
            if (!$isUploaded)
                return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                    new MessageBag([
                        "message" => trans('errors.errorUploadAvatar')
                    ]));
            Utilities::DeleteFile($service->{$fieldName});
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
        $timeBeforeNextVisit = Service::find($serviceId)->time_before_next_visit;
        $calendar = ServicesCalendar::where('service_id', $serviceId)
            ->where('city_id', $cityID)
            ->where('start_date', 'like', "%$day%")
            ->where(function ($query) use ($startDate, $endDate, $timeBeforeNextVisit) {
                $query->where(function ($query) use ($startDate, $endDate, $timeBeforeNextVisit) {
                    $query->where('start_date', '=', $startDate)
                        ->whereRaw('DATE_ADD(end_date, INTERVAL ' . $timeBeforeNextVisit . ' MINUTE) = ' . "'$endDate'");
                })
                    ->orWhere(function ($query) use ($startDate, $endDate, $timeBeforeNextVisit) {
                        $query->where('start_date', '<', $startDate)
                            ->whereRaw('DATE_ADD(end_date, INTERVAL ' . $timeBeforeNextVisit . ' MINUTE) > ' . "'$endDate'");
                    })
                    ->orWhere(function ($query) use ($startDate, $endDate, $timeBeforeNextVisit) {
                        $query->where('start_date', '<', $endDate)
                            ->where('start_date', '>', $startDate)
                            ->whereRaw('DATE_ADD(end_date, INTERVAL ' . $timeBeforeNextVisit . ' MINUTE) > ' . "'$endDate'");
                    })
                    ->orWhere(function ($query) use ($startDate, $endDate, $timeBeforeNextVisit) {
                        $query->where('start_date', '>', $startDate)
                            ->whereRaw('DATE_ADD(end_date, INTERVAL ' . $timeBeforeNextVisit . ' MINUTE) < ' . "'$endDate'");
                    })
                    ->orWhere(function ($query) use ($startDate, $endDate, $timeBeforeNextVisit) {
                        $query->where('start_date', '<', $startDate)
                            ->whereRaw('DATE_ADD(end_date, INTERVAL ' . $timeBeforeNextVisit . ' MINUTE) < ' . "'$endDate'")
                            ->whereRaw('DATE_ADD(end_date, INTERVAL ' . $timeBeforeNextVisit . ' MINUTE) > ' . "'$startDate'");
                    })
                    ->orWhere(function ($query) use ($startDate, $endDate, $timeBeforeNextVisit) {
                        $query->where('start_date', '<', $startDate)
                            ->whereRaw('DATE_ADD(end_date, INTERVAL ' . $timeBeforeNextVisit . ' MINUTE) = ' . "'$endDate'");
                    })
                    ->orWhere(function ($query) use ($startDate, $endDate, $timeBeforeNextVisit) {
                        $query->where('start_date', '>', $startDate)
                            ->whereRaw('DATE_ADD(end_date, INTERVAL ' . $timeBeforeNextVisit . ' MINUTE) = ' . "'$endDate'");
                    })
                    ->orWhere(function ($query) use ($startDate, $endDate, $timeBeforeNextVisit) {
                        $query->where('start_date', '=', $startDate)
                            ->whereRaw('DATE_ADD(end_date, INTERVAL ' . $timeBeforeNextVisit . ' MINUTE) < ' . "'$endDate'");
                    })
                    ->orWhere(function ($query) use ($startDate, $endDate, $timeBeforeNextVisit) {
                        $query->where('start_date', '=', $startDate)
                            ->whereRaw('DATE_ADD(end_date, INTERVAL ' . $timeBeforeNextVisit . ' MINUTE) > ' . "'$endDate'");
                    });
            });
        if ($calendarId) {
            $calendar = $calendar->where('id', '<>', $calendarId);
        }
        $calendar = $calendar->get();
        return !$calendar->isEmpty();
    }

    public static function createOrUpdateCalendar(ServicesCalendar $serviceCalendar, $serviceId, $cityId, $startDate, $endDate, $isAvailable)
    {
        $serviceCalendar->service_id = $serviceId;
        $serviceCalendar->city_id = $cityId;
        $serviceCalendar->start_date = $startDate;
        $serviceCalendar->end_date = $endDate;
        $serviceCalendar->is_available = $isAvailable;
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

    public static function createOrUpdateLapCalendar(LapCalendar $lapCalendar, $cityId, $startDate, $endDate, $isAvailable)
    {
        $lapCalendar->city_id = $cityId;
        $lapCalendar->start_date = $startDate;
        $lapCalendar->end_date = $endDate;
        $lapCalendar->is_available = $isAvailable;
        return $lapCalendar->save();
    }


}