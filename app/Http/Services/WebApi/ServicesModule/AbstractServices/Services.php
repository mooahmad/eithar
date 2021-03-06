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
use App\Listeners\PushNotificationEventListener;
use App\Models\Currency;
use App\Models\InvoiceItems;
use App\Models\LapCalendar;
use App\Models\PromoCode;
use App\Models\Provider;
use App\Models\ProvidersCalendar;
use App\Models\PushNotificationsTypes;
use App\Models\Questionnaire;
use App\Models\Service;
use App\Models\ServiceBooking;
use App\Models\ServiceBookingAnswers;
use App\Models\ServiceBookingAppointment;
use App\Models\ServiceBookingLap;
use App\Models\ServicesCalendar;
use App\Models\TransactionsUsers;
use App\Notifications\AppointmentCanceled;
use App\Notifications\AppointmentConfirmed;
use App\Notifications\AppointmentReminder;
use App\Notifications\ApproveItemToInvoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
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
                'desc_en', 'desc_ar', 'calendar',
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
                'options_en', 'options_ar',
            ]);
        });
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([
                "questionnaire" => $questionnaire,
                "pagesCount" => $pagesCount,
                "currentPage" => $page,
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
                if (!empty($bookedSlotsIds)) {
                    $query->whereRaw("services_calendars.id NOT IN (" . implode(',', $bookedSlotsIds) . ")");
                }

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
                    if (!$date) {
                        $day = Carbon::today()->format('Y-m-d');
                    } else {
                        $day = Carbon::parse($date->start_date)->format('Y-m-d');
                    }

                    $query->where('services_calendars.city_id', '=', Auth::user()->city_id)
                        ->where('services_calendars.start_date', 'like', "%$day%");
                } else {
                    $query->where('services_calendars.city_id', '=', Auth::user()->city_id)
                        ->where('services_calendars.start_date', 'like', "%$day%");
                }
                if (!empty($bookedSlotsIds)) {
                    $query->whereRaw("services_calendars.id NOT IN (" . implode(',', $bookedSlotsIds) . ")");
                }

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
            if (!$date) {
                $day = Carbon::today()->format('Y-m-d');
            } else {
                $day = Carbon::parse($date->start_date)->format('Y-m-d');
            }

        }
        $lapCalendars = LapCalendar::where('city_id', '=', Auth::user()->city_id)
            ->where('start_date', 'like', "%$day%");
        if (!empty($bookedSlotsIds) && $bookedSlotsIds[0] != null) {
            $lapCalendars->whereRaw("lap_calendars.id NOT IN (" . implode(',', $bookedSlotsIds) . ")");
        }
        $lapCalendars = $lapCalendars->get();
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
        $providerId = $request->input('provider_id', null);
        if ($isLap) {
            $providerId = null;
        }

        $serviceId = ($serviceId == 0 || $providerId != null) ? null : $serviceId;
        $providerAssignedId = $request->input('provider_assigned_id', null);
        $promoCode = $request->input('promo_code_id');
        $price = $request->input('price');
        $currencyId = $request->input('currency_id');
        $comment = $request->input('comment', '');
        $address = $request->input('address', '');
        $longitude = $request->input('longitude');
        $latitude = $request->input('latitude');
        $familyMemberId = $request->input('family_member_id', null);
        $status = config('constants.bookingStatus.inprogress');
        $statusDescription = "inprogress";
        $lapServicesIds = $request->input('lap_services_ids', []);
        if ($address == '') {
            $address = Auth::user()->address;
            $longitude =  Auth::user()->longitude;
            $latitude =  Auth::user()->latitude;
        }

        $promoCodeData = PromoCode::where('code', $promoCode)->first();
        $promoCodeId = null;
        if ($promoCodeData) {
            $promoCodeId = $promoCodeData->id;
        }

        $serviceBookingId = $this->saveServiceBooking($isLap, $providerId, $providerAssignedId, $serviceId, $promoCodeId, $price, $currencyId, $comment, $address, $familyMemberId, $status, $statusDescription, $lapServicesIds,$longitude,$latitude);
        // service meetings answers table
        $serviceQuestionnaireAnswers = $request->input('service_questionnaire_answers');
        $bookingAnswer = $this->saveBookingAnswers($serviceBookingId, $serviceQuestionnaireAnswers);
        // service meetings appointments table
        $appointmentDate = $request->input('slot_id', null);
        $appointmentPackageDates = $request->input('slot_ids', []);
        $this->saveBookingAppointments($isLap, $providerId, $serviceBookingId, $appointmentDate, $appointmentPackageDates);
        if ($providerId != null) {
            $this->updateSlotStatus($appointmentDate, 0);
        }

        PushNotificationEventListener::fireOnModel(config('constants.customer_message_cloud'), Auth::user());
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([]));
    }

    public function cancelBook($request, $appointmentId)
    {
        $appointment = ServiceBookingAppointment::find($appointmentId);
        $booking = ServiceBooking::find($appointment->service_booking_id);
        $booking->status = config('constants.bookingStatus.canceled');
        $booking->status_desc = "canceled";
        $booking->save();
        $pushTypeData = PushNotificationsTypes::find(config('constants.pushTypes.appointmentcanceled'));
        if ($booking->provider){
        	$pushTypeData->service_type = 5;
            $startDate = ProvidersCalendar::find($appointment->slot_id)->start_date;
        }elseif($booking->is_lap==1){
	        $pushTypeData->service_type = 4;
            $startDate = LapCalendar::find($appointment->slot_id)->start_date;
        }else{
            $pushTypeData->service_type = $booking->service->type;
            $startDate = ServicesCalendar::find($appointment->slot_id)->start_date;

        }
        $pushTypeData->appointment_id = $appointment->id;
        $pushTypeData->send_at = Carbon::now()->format('Y-m-d H:m:s');
        $customer =  Auth::user();
        $day = Carbon::parse($startDate)->format('Y-m-d');
        $time = Carbon::parse($startDate)->format('g:i A');
        $desc_ar = $pushTypeData->desc_ar;
        $desc_en = $pushTypeData->desc_en;

        $descAr = str_replace('@day', $day, $desc_ar);
        $ar_desc = str_replace('@time', $time, $descAr);

        $descEn = str_replace('@day', $day, $desc_en);
        $en_desc = str_replace('@time', $time, $descEn);


        $pushTypeData->desc_ar = $ar_desc;
        $pushTypeData->desc_en = $en_desc;

        $customer->notify(new AppointmentCanceled($pushTypeData));
        PushNotificationEventListener::fireOnModel(config('constants.customer_message_cloud'), $customer);

        $assignedProvider = $booking->assigned_provider;
        if ($assignedProvider) $assignedProvider->notify(new AppointmentCanceled($pushTypeData));
        PushNotificationEventListener::fireOnModel(config('constants.provider_message_cloud'), $assignedProvider);

        if ($booking->provider) {
            $slot = ProvidersCalendar::find($appointment->slot_id);
            $slot->is_available = 1;
            $slot->save();
        }

        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([]));
    }

    private function notifyBookingReminders($appointmentId, $startDate, $serviceType)
    {
        $now = Carbon::now()->format('Y-m-d H:m:s');
        $pushTypeData = PushNotificationsTypes::find(config('constants.pushTypes.appointmentReminder'));
        $pushTypeData->service_type = $serviceType;
        $pushTypeData->booking_id = $appointmentId;
        $pushTypeData->appointment_date = $startDate;
        $pushTypeData->send_at = Carbon::parse($startDate)->subHours(3)->format('Y-m-d H:m:s');
        if (strtotime($pushTypeData->send_at) > strtotime($now)) {
            Auth::user()->notify(new AppointmentReminder($pushTypeData));
        }

        $pushTypeData->send_at = Carbon::parse($startDate)->subHours(24)->format('Y-m-d H:m:s');
        if (strtotime($pushTypeData->send_at) > strtotime($now)) {
            Auth::user()->notify(new AppointmentReminder($pushTypeData));
        }

        $pushTypeData->send_at = Carbon::parse($startDate)->subHours(72)->format('Y-m-d H:m:s');
        if (strtotime($pushTypeData->send_at) > strtotime($now)) {
            Auth::user()->notify(new AppointmentReminder($pushTypeData));
        }

    }

    private function updateSlotStatus($slotId, $isAvailsble)
    {
        $slot = ProvidersCalendar::find($slotId);
        $slot->is_available = $isAvailsble;
        $slot->save();
    }

    private function saveServiceBooking($isLap, $providerId, $providerAssignedId, $serviceId, $promoCodeId, $price, $currencyId, $comment, $address, $familyMemberId, $status, $statusDescription, $lapServicesIds,$longitude,$latitude)
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
        $booking->longitude = $longitude;
        $booking->latitude = $latitude;
        $booking->status = $status;
        $booking->status_desc = $statusDescription;
        $booking->save();
        if ($serviceId == 0) {
            $data = [];
            foreach ($lapServicesIds as $lapServicesId) {
                $data[] = ["service_booking_id" => $booking->id, "service_id" => $lapServicesId];
            }

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
                "answer" => serialize($value),
            ];
        }
        return ServiceBookingAnswers::insert($data);
    }

    private function saveBookingAppointments($isLap, $providerId, $serviceBookingId, $appointmentDate, $appointmentDates)
    {
        $pushTypeData = PushNotificationsTypes::find(config('constants.pushTypes.appointmentConfirmed'));
        if ($appointmentDate != null && $appointmentDates == []) {
            $bookingAppointment = new ServiceBookingAppointment();
            $bookingAppointment->service_booking_id = $serviceBookingId;
            $bookingAppointment->slot_id = $appointmentDate;
            $bookingAppointment->save();
            // push notification confirmation
            $pushTypeData->booking_id = $bookingAppointment->id;

          //  $pushTypeData->booking_id = $serviceBookingId;

            $pushTypeData->send_at = Carbon::now()->format('Y-m-d H:m:s');
            // push notification reminders
            if ($appointmentDate != null && $isLap) {
                $pushTypeData->service_type = 4;
                $startDate = LapCalendar::find($appointmentDate)->start_date;
                $pushTypeData->appointment_date = $startDate;
                Auth::user()->notify(new AppointmentConfirmed($pushTypeData));
              //  $this->notifyBookingReminders($bookingAppointment->id, $startDate, 4);
                $this->notifyBookingReminders($bookingAppointment->service_booking_id, $startDate, 4);
            } elseif ($appointmentDate != null && $providerId == null && !$isLap) {
                $pushTypeData->service_type = 1;
                $startDate = ServicesCalendar::find($appointmentDate)->start_date;
                $pushTypeData->appointment_date = $startDate;
                Auth::user()->notify(new AppointmentConfirmed($pushTypeData));
                $this->notifyBookingReminders($bookingAppointment->service_booking_id, $startDate, 1);
            } elseif ($appointmentDate != null && $providerId != null && !$isLap) {
                $pushTypeData->service_type = 5;
                $startDate = ProvidersCalendar::find($appointmentDate)->start_date;
                $pushTypeData->appointment_date = $startDate;
                Auth::user()->notify(new AppointmentConfirmed($pushTypeData));
                $provider = Provider::find($providerId);
                $provider->notify(new AppointmentConfirmed($pushTypeData));
                PushNotificationEventListener::fireOnModel(config('constants.provider_message_cloud'), $provider);
                $this->notifyBookingReminders($bookingAppointment->service_booking_id, $startDate, 5);
            }
        } elseif ($appointmentDates != []) {
            foreach ($appointmentDates as $appointmentDate) {
                $serviceBookingAppointment = new ServiceBookingAppointment();
                $serviceBookingAppointment->service_booking_id = $serviceBookingId;
                $serviceBookingAppointment->slot_id = $appointmentDate;
                $serviceBookingAppointment->save();
                // push notifications
                $startDate = ServicesCalendar::find($appointmentDate)->start_date;
                $pushTypeData->service_type = 2;
                $pushTypeData->appointment_date = $startDate;
                Auth::user()->notify(new AppointmentConfirmed($pushTypeData));
                $this->notifyBookingReminders($serviceBookingAppointment->service_booking_id , $startDate, 2);
            }
        }
        return true;
    }

	public function likeService($request, $serviceId)
	{
		$description = $request->input('description', '');
		$userId = Auth::guard('customer-web')->user() ? Auth::guard('customer-web')->user()->id : Auth::id();
		$userTransaction = TransactionsUsers::where('user_id', '=', $userId)->where('service_provider_id','=',$serviceId)->where('type', '=', config('constants.transactionsTypes.service'))->where('transaction_type', '=', config('constants.transactions.like'))->first();
		if ($userTransaction) {

			return Utilities::getValidationError(config('constants.responseStatus.operationFailed'),

				new MessageBag([]));
		}else{

			$this->like($serviceId, config('constants.transactionsTypes.service'), $description);
			return Utilities::getValidationError(config('constants.responseStatus.success'),
				new MessageBag([]));
		}
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

		$userId = Auth::guard('customer-web')->user() ? Auth::guard('customer-web')->user()->id : Auth::id();
		$userTransaction = TransactionsUsers::where('user_id', '=', $userId)->where('service_provider_id', '=', $serviceId)->where('type', '=', config('constants.transactionsTypes.service'))->where('transaction_type', '=', config('constants.transactions.follow'))->first();
		if ($userTransaction) {

			return Utilities::getValidationError(config('constants.responseStatus.operationFailed'),
				new MessageBag([]));
		} else {
			$this->follow($serviceId, config('constants.transactionsTypes.service'), $description);
			return Utilities::getValidationError(config('constants.responseStatus.success'),
				new MessageBag([]));
		}
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
        if (!Auth::user()->is_saudi_nationality) {
            $service->vat = config('constants.vat_percentage');
        }

        $service->currency_name = Currency::find($service->currency_id)->name_eng;
        $service->total_price = $service->price + Utilities::calcPercentage($service->price, $service->vat);
        $isLap = false;
        if ($service->type == 4) {
            $isLap = true;
        }

        $bookedSlotsIds = (new Customer())->getBookedSlots($isLap);
        if ($service->type == 4) {
            if (empty($day)) {
                $date = LapCalendar::where('start_date', '>', Carbon::now()->addHours(2)->format('Y-m-d H:m:s'))
                    ->where('is_available', 1)
                    ->orderBy('start_date', 'asc')
                    ->first();
                if (!$date) {
                    $day = Carbon::today()->format('Y-m-d');
                } else {
                    $day = Carbon::parse($date->start_date)->format('Y-m-d');
                }

            }
            $lapCalendars = LapCalendar::where('city_id', '=', Auth::user()->city_id)
                ->where('start_date', 'like', "%$day%");
            if (!empty($bookedSlotsIds) && $bookedSlotsIds[0] != null) {
                $lapCalendars->whereRaw("lap_calendars.id NOT IN (" . implode(',', $bookedSlotsIds) . ")");
            }

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
                    ->where('start_date', '>', Carbon::now()->addHours(2)->format('Y-m-d H:m:s'))
                    ->where('is_available', 1);
                if (!empty($bookedSlotsIds)) {
                    $query->whereRaw("services_calendars.id NOT IN (" . implode(',', $bookedSlotsIds) . ")");
                }

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
                    if (!in_array($day, $availableDays)) {
                        array_push($availableDays, $day);
                    }

                    $currentWeekOfYear = $currentWeek;
                    $numberOfDaysInCurrentWeek = 0;
                }
            }
            for ($i = 0; $i < $numberOfVisits; $i++) {
                if (!isset($availableDays[$i])) {
                    break;
                }

                $currentCalendar = ApiHelpers::reBuildCalendar($availableDays[$i], $service->calendar);
                array_push($packageCalendar, $currentCalendar);
            }
            $service->calendar_package = $packageCalendar;
        } elseif ($service->type == 1) {
            $service->load(['calendar' => function ($query) use (&$day, $service, $bookedSlotsIds) {
                if (empty($day)) {
                    $date = Service::join('services_calendars', 'services.id', 'services_calendars.service_id')
                        ->where('services.id', $service->id)
                        ->where('services_calendars.start_date', '>', Carbon::now()->addHours(2)->format('Y-m-d H:m:s'))
                        ->where('services_calendars.is_available', 1)
                        ->orderBy('services_calendars.start_date', 'asc')
                        ->first();
                    if (!$date) {
                        $day = Carbon::today()->format('Y-m-d');
                    } else {
                        $day = Carbon::parse($date->start_date)->format('Y-m-d');
                    }

                    $query->where('services_calendars.city_id', '=', Auth::user()->city_id)
                        ->where('services_calendars.start_date', 'like', "%$day%");
                } else {
                    $query->where('services_calendars.city_id', '=', Auth::user()->city_id)
                        ->where('services_calendars.start_date', 'like', "%$day%");
                }
                if (!empty($bookedSlotsIds)) {
                    $query->whereRaw("services_calendars.id NOT IN (" . implode(',', $bookedSlotsIds) . ")");
                }

            }]);
            $service->calendar_dates = ApiHelpers::reBuildCalendar($day, $service->calendar);
        }
        $service->addHidden(['calendar']);
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([
                "service" => $service,
            ]));

    }

    /**
     * @param $request
     * @return \App\Helpers\ValidationError
     */
    public function changeItemStatus($request)
    {
        $invoice_item_id = $request->input('id');
        $status = $request->input('status');
        if ($invoice_item_id > 0 && in_array($status, [config('constants.items.pending'), config('constants.items.approved')])) {
            $invoice_item = InvoiceItems::withTrashed()
                ->where('id', $invoice_item_id)
                ->get()->first();
            $invoice_item->status = $status;
            $invoice_item->isAction = 1;
            $invoice_item->save();
            $notifications = Auth::user()->notifications()->where('is_pushed', 1)->get();
            foreach ($notifications as $notification) {
                $notificationData = json_decode(json_encode($notification->data));
                if ($notificationData->related_id == $invoice_item->id) {
                    $notification->hidden = 1;
                    $notification->save();
//                    return Utilities::getValidationError(config('constants.responseStatus.operationFailed'),
//                        new MessageBag([
//                            "message" => $notification,
//                        ]));


                }
            }

            if ($invoice_item->status == 2) {
                if ($invoice_item) {
                    $provider = $invoice_item->invoice->provider;
                    $pushTypeData = PushNotificationsTypes::find(config('constants.pushTypes.approveItemToInvoice'));
                    if ($invoice_item->invoice->booking_service->provider) {
                        $pushTypeData->service_type = 5;
                    } else {
                        $pushTypeData->service_type = $invoice_item->invoice->booking_service->service->type;
                    }
                    $pushTypeData->booking_id = $invoice_item->invoice->booking_service->id;
                    $pushTypeData->send_at = Carbon::now()->format('Y-m-d H:m:s');
                    if ($provider) {
                        $provider->notify(new ApproveItemToInvoice($pushTypeData));
                        PushNotificationEventListener::fireOnModel(config('constants.provider_message_cloud'), $provider);
                    }
                    return Utilities::getValidationError(config('constants.responseStatus.success'),
                        new MessageBag([]));
                }
            } elseif ($invoice_item->status == 1) {
                if ($invoice_item) {
                    $provider = $invoice_item->invoice->provider;
                    $pushTypeData = PushNotificationsTypes::find(config('constants.pushTypes.cancelItemInvoice'));
                    if ($invoice_item->invoice->booking_service->provider) {
                        $pushTypeData->service_type = 5;
                    } else {
                        $pushTypeData->service_type = $invoice_item->invoice->booking_service->service->type;
                    }
                    $pushTypeData->booking_id = $invoice_item->invoice->booking_service->id;
                    $pushTypeData->send_at = Carbon::now()->format('Y-m-d H:m:s');
                    if ($provider) {
                        $provider->notify(new ApproveItemToInvoice($pushTypeData));
                        PushNotificationEventListener::fireOnModel(config('constants.provider_message_cloud'), $provider);
                    }
                    return Utilities::getValidationError(config('constants.responseStatus.success'),
                        new MessageBag([]));
                }
            }
        }

        return Utilities::getValidationError(config('constants.responseStatus.operationFailed'),
            new MessageBag([
                "message" => "Invalid item and status",
            ]));
    }
}
