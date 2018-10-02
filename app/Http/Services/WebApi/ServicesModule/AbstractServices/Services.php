<?php

namespace App\Http\Services\WebApi\ServicesModule\AbstractServices;

use App\Helpers\ApiHelpers;
use App\Helpers\Utilities;
use App\Http\Services\WebApi\CommonTraits\Follows;
use App\Http\Services\WebApi\CommonTraits\Likes;
use App\Http\Services\WebApi\CommonTraits\Ratings;
use App\Http\Services\WebApi\CommonTraits\Reviews;
use App\Http\Services\WebApi\CommonTraits\Views;
use App\Http\Services\WebApi\ServicesModule\IServices\IService;
use App\Http\Services\WebApi\UsersModule\AbstractUsers\Customer;
use App\LapCalendar;
use App\Models\Currency;
use App\Models\ProvidersCalendar;
use App\Models\PushNotificationsTypes;
use App\Models\Questionnaire;
use App\Models\Service;
use App\Models\ServiceBooking;
use App\Models\ServiceBookingAnswers;
use App\Models\ServiceBookingAppointment;
use App\Models\ServiceBookingLap;
use App\Models\ServicesCalendar;
use App\Notifications\AppointmentConfirmed;
use App\Notifications\AppointmentReminder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class Services implements IService
{
    use Likes, Follows, Views, Ratings, Reviews;

    public static function getCategoryServices($request, $categoryID, $day)
    {
        // calendar for one time visit only
        $services = Service::where('category_id', $categoryID)->where('type', '<>', 3)->get();
        $services = $services->each(function ($service) use ($day) {
            $service->addHidden([
                'name_en', 'name_ar',
                'desc_en', 'desc_ar', 'calendar'
            ]);
        });
        return $services;
    }

    public function getServiceQuestionnaire($id, $page = 1)
    {
        $id = ($id == 0) ? null : $id;
        $pagesCount = Questionnaire::where('service_id', $id)->max('pagination');
        $questionnaire = Questionnaire::where([['service_id', $id], ['pagination', $page]])->get();
        $questionnaire->each(function ($questionnaire) {
            $questionnaire->options_ar = empty(unserialize($questionnaire->options_ar)) ? [] : unserialize($questionnaire->options_ar);
            $questionnaire->options_en = empty(unserialize($questionnaire->options_en)) ? [] : unserialize($questionnaire->options_en);
            $questionnaire->addHidden([
                'title_ar', 'title_en', 'subtitle_ar', 'subtitle_en',
                'options_en', 'options_ar'
            ]);
        });
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([
                "questionnaire" => $questionnaire,
                "pagesCount" => $pagesCount,
                "currentPage" => $page
            ]));
    }

    public function getServiceCalendar(Request $request, $serviceId)
    {
        $day = $request->input('day');
        $bookedSlotsIds = (new Customer())->getBookedSlots();
        $service = Service::find($serviceId);
        if ($service->type == 2) {
            $service->load(['calendar' => function ($query) use ($day, $service, $bookedSlotsIds) {
                $query->where('city_id', '=', Auth::user()->city_id)
                    ->where('start_date', 'Like', "%$day%")
                    ->where('is_available', 1);
                if (!empty($bookedSlotsIds))
                    $query->whereRaw("services_calendars.id NOT IN (" . implode(',', $bookedSlotsIds) . ")");
            }]);
            $service->calendar_dates = ApiHelpers::reBuildCalendar($day, $service->calendar);
        } elseif ($service->type == 1) {
            $service->load(['calendar' => function ($query) use (&$day, $service, $bookedSlotsIds) {
                if (empty($day)) {
                    $date = Service::join('services_calendars', 'services.id', 'services_calendars.service_id')
                        ->where('services.id', $service->id)
                        ->where('services_calendars.start_date', '>', Carbon::now()->format('Y-m-d H:m:s'))
                        ->where('services_calendars.is_available', 1)
                        ->orderBy('services_calendars.start_date', 'asc')
                        ->first();
                    if (!$date)
                        $day = Carbon::today()->format('Y-m-d');
                    else
                        $day = Carbon::parse($date->start_date)->format('Y-m-d');
                    $query->where('services_calendars.city_id', '=', Auth::user()->city_id)
                        ->where('services_calendars.start_date', 'like', "%$day%");
                } else {
                    $query->where('services_calendars.city_id', '=', Auth::user()->city_id)
                        ->where('services_calendars.start_date', 'like', "%$day%");
                }
                if (!empty($bookedSlotsIds))
                    $query->whereRaw("services_calendars.id NOT IN (" . implode(',', $bookedSlotsIds) . ")");
            }]);
            $service->calendar_dates = ApiHelpers::reBuildCalendar($day, $service->calendar);
        }
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([
                "calendar" => $service->calendar_dates,
            ]));
    }

    public function getLapCalendar(Request $request)
    {
        $day = $request->input('day', null);
        $bookedSlotsIds = (new Customer())->getBookedSlots(true);
        if (empty($day)) {
            $date = LapCalendar::where('start_date', '>', Carbon::now()->format('Y-m-d H:m:s'))
                ->where('is_available', 1)
                ->whereRaw("lap_calendars.id NOT IN (" . implode(',', $bookedSlotsIds) . ")")
                ->orderBy('start_date', 'asc')
                ->first();
            if (!$date)
                $day = Carbon::today()->format('Y-m-d');
            else
                $day = Carbon::parse($date->start_date)->format('Y-m-d');
        }
        $lapCalendars = LapCalendar::where('city_id', '=', Auth::user()->city_id)
            ->where('start_date', 'like', "%$day%");
        if (!empty($bookedSlotsIds) && $bookedSlotsIds[0] != null)
            $lapCalendars->whereRaw("lap_calendars.id NOT IN (" . implode(',', $bookedSlotsIds) . ")");
        $lapCalendars->get();
        $lapCalendar = ApiHelpers::reBuildCalendar($day, $lapCalendars);
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([
                "calendar" => $lapCalendar,
            ]));
    }

    public function book($request, $serviceId)
    {
        // service meetings table
        $isLap = ($serviceId == 0) ? 1 : 0;
        $serviceId = ($serviceId == 0) ? null : $serviceId;
        $providerId = $request->input('provider_id', null);
        $providerAssignedId = $request->input('provider_assigned_id', null);
        $promoCodeId = $request->input('promo_code_id');
        $price = $request->input('price');
        $currencyId = $request->input('currency_id');
        $comment = $request->input('comment', '');
        $address = $request->input('address', '');
        $familyMemberId = $request->input('family_member_id', null);
        $status = config('constants.bookingStatus.inprogress');
        $statusDescription = "inprogress";
        $lapServicesIds = $request->input('lap_services_ids', []);
        $serviceBookingId = $this->saveServiceBooking($isLap, $providerId, $providerAssignedId, $serviceId, $promoCodeId, $price, $currencyId, $comment, $address, $familyMemberId, $status, $statusDescription, $lapServicesIds);
        // service meetings answers table
        $serviceQuestionnaireAnswers = $request->input('service_questionnaire_answers');
        $bookingAnswer = $this->saveBookingAnswers($serviceBookingId, $serviceQuestionnaireAnswers);
        // service meetings appointments table
        $appointmentDate = $request->input('slot_id', null);
        $appointmentPackageDates = $request->input('slot_ids', []);
        $this->saveBookingAppointments($serviceBookingId, $appointmentDate, $appointmentPackageDates);
        if ($providerId != null)
            $this->updateSlotStatus($appointmentDate, 0);
        // push notification confirmation
        $pushTypeData = PushNotificationsTypes::find(config('constants.pushTypes.appointmentConfirmed'));
        $pushTypeData->booking_id = $serviceBookingId;
        $pushTypeData->send_at = Carbon::now()->format('Y-m-d H:m:s');
        Auth::user()->notify(new AppointmentConfirmed($pushTypeData));
        // push notification reminders
        if ($appointmentDate != null && $isLap) {
            $startDate = LapCalendar::find($appointmentDate)->start_date;
            $this->notifyBookingReminders($serviceBookingId, $startDate);
        } elseif ($appointmentDate != null && $providerId == null && !$isLap) {
            $startDate = ServicesCalendar::find($appointmentDate)->start_date;
            $this->notifyBookingReminders($serviceBookingId, $startDate);
        } elseif ($appointmentDate != null && $providerId != null && !$isLap) {
            $startDate = ProvidersCalendar::find($appointmentDate)->start_date;
            $this->notifyBookingReminders($serviceBookingId, $startDate);
        } elseif ($appointmentDate == null && $appointmentPackageDates != null && !$isLap) {
            foreach ($appointmentPackageDates as $appointmentPackageDate) {
                $startDate = ServicesCalendar::find($appointmentPackageDate)->start_date;
                $this->notifyBookingReminders($serviceBookingId, $startDate);
            }
        }
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([]));
    }

    private function notifyBookingReminders($serviceBookingId, $startDate)
    {
        $now = Carbon::now()->format('Y-m-d H:m:s');
        $pushTypeData = PushNotificationsTypes::find(config('constants.pushTypes.appointmentReminder'));
        $pushTypeData->booking_id = $serviceBookingId;
        $pushTypeData->send_at = Carbon::parse($startDate)->subHours(3)->format('Y-m-d H:m:s');
        if (strtotime($pushTypeData->send_at) > strtotime($now))
            Auth::user()->notify(new AppointmentReminder($pushTypeData));
        $pushTypeData->send_at = Carbon::parse($startDate)->subHours(24)->format('Y-m-d H:m:s');
        if (strtotime($pushTypeData->send_at) > strtotime($now))
            Auth::user()->notify(new AppointmentReminder($pushTypeData));
        $pushTypeData->send_at = Carbon::parse($startDate)->subHours(72)->format('Y-m-d H:m:s');
        if (strtotime($pushTypeData->send_at) > strtotime($now))
            Auth::user()->notify(new AppointmentReminder($pushTypeData));
    }

    private function updateSlotStatus($slotId, $isAvailsble)
    {
        $slot = ProvidersCalendar::find($slotId);
        $slot->is_available = $isAvailsble;
        $slot->save();
    }

    private function saveServiceBooking($isLap, $providerId, $providerAssignedId, $serviceId, $promoCodeId, $price, $currencyId, $comment, $address, $familyMemberId, $status, $statusDescription, $lapServicesIds)
    {
        $booking = new ServiceBooking();
        $booking->customer_id = Auth::id();
        $booking->service_id = $serviceId;
        $booking->provider_id = $providerId;
        $booking->provider_id_assigned_by_admin = $providerAssignedId;
        $booking->promo_code_id = $promoCodeId;
        $booking->currency_id = $currencyId;
        $booking->family_member_id = $familyMemberId;
        $booking->is_lap = $isLap;
        $booking->price = $price;
        $booking->comment = $comment;
        $booking->address = $address;
        $booking->status = $status;
        $booking->status_desc = $statusDescription;
        $booking->save();
        if ($serviceId == 0) {
            $data = [];
            foreach ($lapServicesIds as $lapServicesId)
                $data[] = ["service_booking_id" => $booking->id, "service_id" => $lapServicesId];
            ServiceBookingLap::insert($data);
        }
        return $booking->id;
    }

    private function saveBookingAnswers($serviceBookingId, $serviceQuestionnaireAnswers)
    {
        $data = [];
        foreach ($serviceQuestionnaireAnswers as $key => $value) {
            $questionnaire = Questionnaire::find($key);
            $data[] = [
                "service_booking_id" => $serviceBookingId,
                "service_questionnaire_id" => $questionnaire->id,
                "title_ar" => $questionnaire->title_ar,
                "title_en" => $questionnaire->title_en,
                "subtitle_ar" => $questionnaire->subtitle_ar,
                "subtitle_en" => $questionnaire->subtitle_en,
                "options_ar" => $questionnaire->options_ar,
                "options_en" => $questionnaire->options_en,
                "is_required" => $questionnaire->is_required,
                "rating_levels" => $questionnaire->rating_levels,
                "rating_symbol" => $questionnaire->rating_symbol,
                "order" => $questionnaire->order,
                "pagination" => $questionnaire->pagination,
                "type" => $questionnaire->type,
                "answer" => serialize($value)
            ];
        }
        return ServiceBookingAnswers::insert($data);
    }

    private function saveBookingAppointments($serviceBookingId, $appointmentDate, $appointmentDates)
    {
        if ($appointmentDate != null && $appointmentDates == []) {
            $bookingAppointment = new ServiceBookingAppointment();
            $bookingAppointment->service_booking_id = $serviceBookingId;
            $bookingAppointment->slot_id = $appointmentDate;
            $bookingAppointment->save();
        } elseif ($appointmentDates != []) {
            $data = [];
            foreach ($appointmentDates as $appointmentDate)
                array_push($data, ["service_booking_id" => $serviceBookingId, "slot_id" => $appointmentDate]);
            ServiceBookingAppointment::insert($data);
        }
        return true;
    }

    public function likeService($request, $serviceId)
    {
        $description = $request->input('description', '');
        $this->like($serviceId, config('constants.transactionsTypes.service'), $description);
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([]));
    }

    public function unlikeService($request, $serviceId)
    {
        $this->unlike($serviceId);
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([]));
    }

    public function followService($request, $serviceId)
    {
        $description = $request->input('description', '');
        $this->follow($serviceId, config('constants.transactionsTypes.service'), $description);
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([]));
    }

    public function unFollowService($request, $serviceId)
    {
        $this->unFollow($serviceId);
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([]));
    }

    public function rateService($request, $serviceId)
    {
        $description = $request->input('description', '');
        $this->rate($serviceId, config('constants.transactionsTypes.service'), $description);
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([]));
    }

    public function reviewService($request, $serviceId)
    {
        $description = $request->input('description', '');
        $this->review($serviceId, config('constants.transactionsTypes.service'), $description);
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([]));
    }

    public function viewService($request, $serviceId)
    {
        $description = $request->input('description', '');
        $this->view($serviceId, config('constants.transactionsTypes.service'), $description);
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([]));
    }

    public function getService($request, $id)
    {
        $day = $request->input('day');
        $service = Service::find($id);
        $service->vat = 0;
        if (!Auth::user()->is_saudi_nationality)
            $service->vat = config('constants.vat_percentage');
        $service->currency_name = Currency::find($service->currency_id)->name_eng;
        $service->total_price = $service->price + Utilities::calcPercentage($service->price, $service->vat);
        $isLap = false;
        if ($service->type == 4)
            $isLap = true;
        $bookedSlotsIds = (new Customer())->getBookedSlots($isLap);
        if ($service->type == 4) {
            if (empty($day)) {
                $date = LapCalendar::where('start_date', '>', Carbon::now()->format('Y-m-d H:m:s'))
                    ->where('is_available', 1)
                    ->where('lap_calendars.start_date', '>', Carbon::now()->format('Y-m-d H:m:s'))
                    ->orderBy('start_date', 'asc')
                    ->first();
                if (!$date)
                    $day = Carbon::today()->format('Y-m-d');
                else
                    $day = Carbon::parse($date->start_date)->format('Y-m-d');
            }
            $lapCalendars = LapCalendar::where('city_id', '=', Auth::user()->city_id)
                ->where('start_date', 'like', "%$day%");
            if (!empty($bookedSlotsIds) && $bookedSlotsIds[0] != null)
                $lapCalendars->whereRaw("lap_calendars.id NOT IN (" . implode(',', $bookedSlotsIds) . ")");
            $lapCalendars->get();
            $service->calendar_dates = ApiHelpers::reBuildCalendar($day, $lapCalendars);
        } elseif ($service->type == 2) {
            $packageCalendar = [];
            $availableDays = [];
            $numberOfVisits = $service->no_of_visits;
            $maxWeekVisits = $service->visits_per_week;
            $currentWeekOfYear = null;
            $numberOfDaysInCurrentWeek = 0;
            $service->load(['calendar' => function ($query) use ($id, $service, $bookedSlotsIds) {
                $query->where('city_id', '=', Auth::user()->city_id)
                    ->where('start_date', '>', Carbon::now()->format('Y-m-d H:m:s'))
                    ->where('is_available', 1);
                if (!empty($bookedSlotsIds))
                    $query->whereRaw("services_calendars.id NOT IN (" . implode(',', $bookedSlotsIds) . ")");
            }]);
            foreach ($service->calendar as $date) {
                $currentWeek = Carbon::parse($date->start_date)->weekOfYear;
                if ($currentWeek == $currentWeekOfYear || $currentWeekOfYear == null) {
                    if ($maxWeekVisits > $numberOfDaysInCurrentWeek) {
                        $day = Carbon::parse($date->start_date)->format('Y-m-d');
                        if (!in_array($day, $availableDays)) {
                            array_push($availableDays, $day);
                            $currentWeekOfYear = $currentWeek;
                            $numberOfDaysInCurrentWeek += 1;
                        }
                    }
                } else {
                    if (!in_array($day, $availableDays))
                        array_push($availableDays, $day);
                    $currentWeekOfYear = $currentWeek;
                    $numberOfDaysInCurrentWeek = 0;
                }
            }
            for ($i = 0; $i < $numberOfVisits; $i++) {
                if (!isset($availableDays[$i]))
                    break;
                $currentCalendar = ApiHelpers::reBuildCalendar($availableDays[$i], $service->calendar);
                array_push($packageCalendar, $currentCalendar);
            }
            $service->calendar_package = $packageCalendar;
        } elseif ($service->type == 1) {
            $service->load(['calendar' => function ($query) use (&$day, $service, $bookedSlotsIds) {
                if (empty($day)) {
                    $date = Service::join('services_calendars', 'services.id', 'services_calendars.service_id')
                        ->where('services.id', $service->id)
                        ->where('services_calendars.start_date', '>', Carbon::now()->format('Y-m-d H:m:s'))
                        ->where('services_calendars.is_available', 1)
                        ->orderBy('services_calendars.start_date', 'asc')
                        ->first();
                    if (!$date)
                        $day = Carbon::today()->format('Y-m-d');
                    else
                        $day = Carbon::parse($date->start_date)->format('Y-m-d');
                    $query->where('services_calendars.city_id', '=', Auth::user()->city_id)
                        ->where('services_calendars.start_date', 'like', "%$day%");
                } else {
                    $query->where('services_calendars.city_id', '=', Auth::user()->city_id)
                        ->where('services_calendars.start_date', 'like', "%$day%");
                }
                if (!empty($bookedSlotsIds))
                    $query->whereRaw("services_calendars.id NOT IN (" . implode(',', $bookedSlotsIds) . ")");
            }]);
            $service->calendar_dates = ApiHelpers::reBuildCalendar($day, $service->calendar);
        }
        $service->addHidden(['calendar']);
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([
                "service" => $service
            ]));

    }
}