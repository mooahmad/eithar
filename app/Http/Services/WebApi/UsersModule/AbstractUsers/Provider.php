<?php

namespace App\Http\Services\WebApi\UsersModule\AbstractUsers;


use App\Helpers\ApiHelpers;
use App\Helpers\Utilities;
use App\Http\Requests\Auth\LoginProvider;
use App\Http\Requests\Auth\RegisterProvider;
use App\Http\Services\WebApi\CommonTraits\Follows;
use App\Http\Services\WebApi\CommonTraits\Likes;
use App\Http\Services\WebApi\CommonTraits\Ratings;
use App\Http\Services\WebApi\CommonTraits\Reviews;
use App\Http\Services\WebApi\CommonTraits\Views;
use App\Models\BookingMedicalReports;
use App\Models\Currency;
use App\Models\MedicalReports;
use App\Models\ProvidersCalendar;
use App\Models\PushNotification;
use App\Models\ServiceBooking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use App\Models\Provider as ProviderModel;
use Illuminate\Support\Facades\Hash;


class Provider
{
    use Likes, Follows, Ratings, Views, Reviews;

    public function getProvider($request, $providerId)
    {
        $day = $request->input('day');
        $provider = ProviderModel::where('id', $providerId)->with(['calendar' => function ($query) use (&$day, $providerId) {
            if (empty($day)) {
                $date = ProvidersCalendar::where('provider_id', $providerId)
                    ->where('start_date', '>', Carbon::now()->format('Y-m-d H:m:s'))
                    ->where('is_available', 1)
                    ->orderBy('start_date', 'desc')
                    ->first();
                if (!$date)
                    $day = Carbon::today()->format('Y-m-d');
                else
                    $day = Carbon::parse($date->start_date)->format('Y-m-d');
                $query->where('providers_calendars.start_date', 'like', "%$day%")
                    ->where('providers_calendars.start_date', '>', Carbon::now()->format('Y-m-d H:m:s'))
                    ->where('providers_calendars.is_available', 1);
            } else {
                $query->where('providers_calendars.start_date', 'like', "%$day%")
                    ->where('providers_calendars.start_date', '>', Carbon::now()->format('Y-m-d H:m:s'))
                    ->where('providers_calendars.is_available', 1);
            }
        }])->first();
        $provider->addHidden([
            'title_ar', 'title_en', 'first_name_ar', 'first_name_en',
            'last_name_ar', 'last_name_en', 'speciality_area_ar', 'speciality_area_en',
            'about_ar', 'about_en', 'experience_ar', 'experience_en', 'education_ar', 'education_en', 'calendar'
        ]);
        $provider->cities = $provider->cities->each(function ($city) {
            $city->addHidden([
                'city_name_ara', 'city_name_eng'
            ]);
        });
        $provider->services->each(function ($service) use (&$provider) {
            if ($service->category->category_parent_id == config('constants.categories.Doctor'))
                $provider->category_name = $service->category->name;
        });
        $provider->currency_name = Currency::find($provider->currency_id)->name_eng;
        $provider->calendar_dates = ApiHelpers::reBuildCalendar($day, $provider->calendar);
        $provider->vat = 0;
        if (!Auth::user()->is_saudi_nationality)
            $provider->vat = config('constants.vat_percentage');
        $provider->total_price = $provider->price + Utilities::calcPercentage($provider->price, $provider->vat);
        $this->view($providerId, config('constants.transactionsTypes.provider'), '');
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([
                "provider" => $provider
            ]));
    }

    public function likeProvider($request, $providerId)
    {
        $description = $request->input('description', '');
        $this->like($providerId, config('constants.transactionsTypes.provider'), $description);
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([]));
    }

    public function unlikeProvider($request, $providerId)
    {
        $this->unlike($providerId);
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([]));
    }

    public function followProvider($request, $providerId)
    {
        $description = $request->input('description', '');
        $this->follow($providerId, config('constants.transactionsTypes.provider'), $description);
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([]));
    }

    public function unFollowProvider($request, $providerId)
    {
        $this->unFollow($providerId);
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([]));
    }

    public function rateProvider($request, $providerId)
    {
        $description = $request->input('description', '');
        $this->rate($providerId, config('constants.transactionsTypes.provider'), $description);
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([]));
    }

    public function reviewProvider($request, $providerId)
    {
        $description = $request->input('description', '');
        $this->review($providerId, config('constants.transactionsTypes.provider'), $description);
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([]));
    }

    public function viewProvider($request, $providerId)
    {
        $description = $request->input('description', '');
        $this->view($providerId, config('constants.transactionsTypes.provider'), $description);
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([]));
    }

    public function getBookingAvailableReports($request, $bookingId)
    {
        $reports = [];
        $generalMedicalReports = MedicalReports::where('service_id', null)->get();
        $generalMedicalReports->each(function ($medicalReport) use (&$reports) {
            $medicalReport->file_path = Utilities::getFileUrl($medicalReport->file_path);
            array_push($reports, $medicalReport);
        });
        $booking = ServiceBooking::find($bookingId);
        if ($booking->service_id == null) {
            $lapServices = $booking->booking_lap_services;
            $lapServices->each(function ($lapService) use (&$reports) {
                $service = $lapService->service;
                $medicalReports = $service->medicalReports;
                $medicalReports->each(function ($medicalReport) use (&$reports) {
                    $medicalReport->file_path = Utilities::getFileUrl($medicalReport->file_path);
                    array_push($reports, $medicalReport);
                });
            });
        } else {
            $service = $booking->service;
            $medicalReports = $service->medicalReports;
            $medicalReports->each(function ($medicalReport) use (&$reports) {
                $medicalReport->file_path = Utilities::getFileUrl($medicalReport->file_path);
                array_push($reports, $medicalReport);
            });
        }
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([
                "reports" => $reports
            ]));
    }

    public function addBookingReport($request, $bookingId)
    {
        $medicalReportId = $request->input('medial_report_id');
        $filePath = Utilities::UploadFile($request->file('report'), 'public/bookings/' . $bookingId . '/reports');
        $bookingMedicalReport = new BookingMedicalReports();
        $this->createUpdateMedicalReport($bookingMedicalReport, $bookingId, $medicalReportId, $request->file('report')->getClientOriginalName(), $filePath);
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([]));
    }

    public function createUpdateMedicalReport($bookingMedicalReport, $bookingId, $medicalReportId, $originalName, $filePath)
    {
        $bookingMedicalReport->provider_id = Auth::id();
        $bookingMedicalReport->service_booking_id = $bookingId;
        $bookingMedicalReport->medical_report_id = $medicalReportId;
        $bookingMedicalReport->original_name = $originalName;
        $bookingMedicalReport->filled_file_path = $filePath;
        $bookingMedicalReport->is_approved = 0;
        $bookingMedicalReport->customer_can_view = 0;
        return $bookingMedicalReport->save();
    }

    public function verifyProviderCredentials(Request $request)
    {
        $validator = Validator::make($request->all(), (new LoginProvider())->rules());
        if ($validator->fails()) {
            return $validator;
        }
        return true;
    }

    public function isProviderExists(Request $request)
    {
        $provider = ProviderModel::where('mobile_number', $request->input('mobile'))->first();
        if (!$provider)
            return false;
        if (!Hash::check($request->input('password'), $provider->password))
            return false;
        return $provider;
    }

    public function updateProviderToken(ProviderModel $provider, Request $request)
    {
        if ($provider->pushNotification)
            $provider->pushNotification->delete();
        $pushNotification = new PushNotification();
        $pushNotification->provider_id = $provider->id;
        $pushNotification->imei = $request->input('imei');
        $pushNotification->device_type = $request->input('device_type');
        $pushNotification->device_language = $request->input('device_language');
        $pushNotification->token = $request->input('token');
        $pushNotification->save();
    }

    public function updateLastLoginDate(ProviderModel $provider)
    {
        $provider->last_login_date = Carbon::now();
        if (!$provider->save())
            return false;
        return true;
    }
}