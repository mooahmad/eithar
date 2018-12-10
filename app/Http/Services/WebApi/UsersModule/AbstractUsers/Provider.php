<?php

namespace App\Http\Services\WebApi\UsersModule\AbstractUsers;

use Carbon\Carbon;
use App\Models\Driver;
use App\Models\JoinUs;
use App\Models\Invoice;
use App\Models\Service;
use App\Models\Currency;
use App\Models\PromoCode;
use App\Helpers\Utilities;
use App\Helpers\ApiHelpers;
use App\Models\DriverTrips;
use App\Models\LapCalendar;
use App\Models\InvoiceItems;
use Illuminate\Http\Request;
use App\Models\MedicalReports;
use App\Models\ServiceBooking;
use App\Models\PushNotification;
use App\Models\ServicesCalendar;
use App\Models\ProvidersCalendar;
use App\Models\ServiceBookingLap;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\BookingMedicalReports;
use App\Models\ServiceBookingAnswers;
use App\Models\PushNotificationsTypes;
use App\Models\MedicalReportsQuestions;
use App\Notifications\AddItemToInvoice;
use App\Http\Requests\Auth\LoginProvider;
use App\Mail\Customer\ForgetPasswordMail;
use App\Models\Provider as ProviderModel;
use App\Models\ServiceBookingAppointment;
use Illuminate\Support\Facades\Validator;
use App\Models\BookingMedicalReportsAnswers;
use App\Http\Services\WebApi\CommonTraits\Likes;
use App\Http\Services\WebApi\CommonTraits\Views;
use App\Listeners\PushNotificationEventListener;
use App\Http\Services\WebApi\CommonTraits\Follows;
use App\Http\Services\WebApi\CommonTraits\Ratings;
use App\Http\Services\WebApi\CommonTraits\Reviews;
use App\Http\Requests\Auth\UpdateForgetPasswordRequest;
use App\Http\Services\WebApi\CategoriesModule\AbstractCategories\Categories;
use App\Http\Services\WebApi\PromoCodesModule\AbstractPromoCodes\PromoCodes;
use App\Http\Services\Adminstrator\InvoiceModule\ClassesInvoice\InvoiceClass;
use App\Http\Controllers\Administrator\BookingServices\BookingServicesController;

class Provider
{
    use Likes, Follows, Ratings, Views, Reviews;

    public function getProvider($request, $providerId)
    {
        $day = $request->input('day');
        $provider = ProviderModel::where('id', $providerId)->with(['calendar' => function ($query) use (&$day, $providerId) {
            if (empty($day)) {
                $date = ProvidersCalendar::where('provider_id', $providerId)
                    ->where('start_date', '>', Carbon::now()->addHours(2)->format('Y-m-d H:m:s'))
                    ->where('is_available', 1)
                    ->orderBy('start_date', 'asc')
                    ->first();
                if (!$date) {
                    $day = Carbon::today()->format('Y-m-d');
                } else {
                    $day = Carbon::parse($date->start_date)->format('Y-m-d');
                }

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
            'about_ar', 'about_en', 'experience_ar', 'experience_en', 'education_ar', 'education_en', 'calendar',
        ]);
        $provider->cities = $provider->cities->each(function ($city) {
            $city->addHidden([
                'city_name_ara', 'city_name_eng',
            ]);
        });
        $provider->category_name = "Doctor";
        $provider->currency_name = Currency::find($provider->currency_id)->name_eng;
        $provider->calendar_dates = ApiHelpers::reBuildCalendar($day, $provider->calendar);
        $provider->vat = 0;
        if (!Auth::user()->is_saudi_nationality) {
            $provider->vat = config('constants.vat_percentage');
        }

        $provider->total_price = $provider->price + Utilities::calcPercentage($provider->price, $provider->vat);
        $this->view($providerId, config('constants.transactionsTypes.provider'), '');
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([
                "provider" => $provider,
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
        $servicesIds = [];
        $booking = ServiceBookingAppointment::find($bookingId)->servicesBooking;
        if ($booking->service_id == null) {
            $lapServices = $booking->booking_lap_services;
            $lapServices->each(function ($lapService) use (&$servicesIds) {
                $service = $lapService->service;
                array_push($servicesIds, $service->id);
            });
        } else {
            $service = $booking->service;
            array_push($servicesIds, $service->id);
        }
        $MedicalReports = MedicalReports::where('service_id', null)->orWhere(function ($query) use ($servicesIds) {
            $query->whereIn('service_id', $servicesIds);
        })->get();
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([
                "reports" => $MedicalReports,
            ]));
    }

    public function getBookingReportQuestions($request, $reportId, $page = 1)
    {
        $pagesCount = MedicalReportsQuestions::where('medical_report_id', $reportId)->max('pagination');
        $medicalReportsQuestions = MedicalReportsQuestions::where([['medical_report_id', $reportId], ['pagination', $page]])->get();
        $medicalReportsQuestions->each(function ($medicalReportsQuestion) {
            $medicalReportsQuestion->options_ar = empty(unserialize($medicalReportsQuestion->options_ar)) ? [] : unserialize($medicalReportsQuestion->options_ar);
            $medicalReportsQuestion->options_en = empty(unserialize($medicalReportsQuestion->options_en)) ? [] : unserialize($medicalReportsQuestion->options_en);
            $medicalReportsQuestion->addHidden([
                'title_ar', 'title_en',
                'options_en', 'options_ar',
            ]);
        });
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([
                "questionnaire" => $medicalReportsQuestions,
                "pagesCount" => $pagesCount,
                "currentPage" => $page,
            ]));
    }

    public function addBookingReport(Request $request, $bookingId)
    {
        $medicalReportId = $request->input('medical_report_id');
        $reportAnswers = $request->input('report_answers');
        $bookingReportId = $this->saveBookingReport($bookingId, $medicalReportId);
        $this->saveBookingReportAnswers($bookingReportId, $reportAnswers);
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([]));
    }

    private function saveBookingReport($bookingId, $medicalReportId)
    {
        $medicalReport = MedicalReports::find($medicalReportId);
        $bookingMedicalReport = new BookingMedicalReports();
        $bookingMedicalReport->service_booking_id = $bookingId;
        $bookingMedicalReport->provider_id = Auth::id();
        $bookingMedicalReport->medical_report_id = $medicalReport->id;
        $bookingMedicalReport->is_approved = 0;
        $bookingMedicalReport->customer_can_view = $medicalReport->customer_can_view;
        $bookingMedicalReport->save();
        return $bookingMedicalReport->id;
    }

    private function saveBookingReportAnswers($bookingReportId, $ReportAnswers)
    {
        $data = [];
        foreach ($ReportAnswers as $key => $value) {
            $reportQuestion = MedicalReportsQuestions::find($key);
            $data[] = [
                "booking_report_id" => $bookingReportId,
                "report_question_id" => $reportQuestion->id,
                "title_ar" => $reportQuestion->title_ar,
                "title_en" => $reportQuestion->title_en,
                "options_ar" => $reportQuestion->options_ar,
                "options_en" => $reportQuestion->options_en,
                "is_required" => $reportQuestion->is_required,
                "order" => $reportQuestion->order,
                "pagination" => $reportQuestion->pagination,
                "type" => $reportQuestion->type,
                "answer" => serialize($value),
            ];
        }
        return BookingMedicalReportsAnswers::insert($data);
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
        if (!$provider) {
            return false;
        }

        if (!Hash::check($request->input('password'), $provider->password)) {
            return false;
        }

        return $provider;
    }

    public function updateProviderToken(ProviderModel $provider, Request $request)
    {
        if ($provider->pushNotification) {
            $pushNotification = $provider->pushNotification;
        } else {
            $pushNotification = new PushNotification();
        }

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
        if (!$provider->save()) {
            return false;
        }

        return true;
    }

    public function logoutProvider(Request $request)
    {
        $pushNotification = Auth::user()->pushNotification;
        $pushNotification->token = null;
        $pushNotification->save();
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([
            ]));
    }

    public function forgetPassword(Request $request)
    {
        $isVerified = $this->validateForgetPassword($request);
        if ($isVerified !== true) {
            return Utilities::getValidationError(config('constants.responseStatus.missingInput'), $isVerified->errors());
        }

        $provider = ProviderModel::where('mobile_number', $request->input('mobile'))->first();
        if (!$provider) {
            return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));
        }

        $encrytedCode = Utilities::quickRandom(6, true);
        $provider->forget_password_code = $encrytedCode;
        $provider->save();
        Mail::to($provider->email)->send(new ForgetPasswordMail($provider));
        return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));

    }

    private function validateForgetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
        ]);
        if ($validator->fails()) {
            return $validator;
        }
        return true;
    }

    public function updateForgottenPassword(Request $request)
    {
        $isVerified = $this->validateUpdateForgetPassword($request);
        if ($isVerified !== true) {
            return Utilities::getValidationError(config('constants.responseStatus.missingInput'), $isVerified->errors());
        }

        $provider = ProviderModel::where([['mobile_number', $request->input('mobile')], ['forget_password_code', $request->input('code')]])->first();
        if (!$provider) {
            return Utilities::getValidationError(config('constants.responseStatus.userNotFound'),
                new MessageBag([
                    'message' => trans('errors.userNotFound'),
                ]));
        }

        $provider->password = Hash::make($request->input('password'));
        $provider->save();
        return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));

    }

    private function validateUpdateForgetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), (new UpdateForgetPasswordRequest())->rules());
        if ($validator->fails()) {
            return $validator;
        }
        return true;
    }

    public function getBookings(Request $request, $page = 1, $eitharId = null)
    {
        $upCommingAppointments = [];
        $passedAppointments = [];
        $finalAppointments = [];
        $page -= 1;
        $servicesBookingsMaxPages = ceil(Auth::user()->load(['servicesBookings.service_appointments' => function ($query) use ($eitharId) {
            if ($eitharId != null) {
                $query->join('service_bookings', 'service_booking_appointments.service_booking_id', 'service_bookings.id');
                $query->join('customers', 'service_bookings.customer_id', 'customers.id')->whereRaw("customers.eithar_id = '$eitharId'");
            }
            $query->orderByRaw('service_booking_appointments.created_at DESC');
        }])->servicesBookings()->count()/config('constants.paggination_items_per_page'));
        $servicesBookings = Auth::user()->load(['servicesBookings.service_appointments' => function ($query) use ($eitharId) {
            if ($eitharId != null) {
                $query->join('service_bookings', 'service_booking_appointments.service_booking_id', 'service_bookings.id');
                $query->join('customers', 'service_bookings.customer_id', 'customers.id')->whereRaw("customers.eithar_id = '$eitharId'");
            }
            $query->orderByRaw('service_booking_appointments.created_at DESC');
        }])->servicesBookings()->skip($page * config('constants.paggination_items_per_page'))->take(config('constants.paggination_items_per_page'))->get();
        foreach ($servicesBookings as $servicesBooking) {
            $service = null;
            $serviceBookingLaps = null;
            $serviceId = $servicesBooking->service_id;
            if ($serviceId != null) {
                $service = Service::find($serviceId);
            } elseif ($serviceId == null && $servicesBooking->provider_id != null && $servicesBooking->is_lap == 0) {
                $service = $servicesBooking->provider;
                $service->type = 5;
            } else {
                $serviceBookingLaps = ServiceBookingLap::with('service')->where('service_booking_id', $servicesBooking->id)->get();
            }
            $serviceAppointments = $servicesBooking->service_appointments;
            $customer = $servicesBooking->customer;
            foreach ($serviceAppointments as $serviceAppointment) {
                $payLoad = [];
                if ($service != null) {
                    //provider
                    if ($service->type == 5) {
                        $calendar = ProvidersCalendar::find($serviceAppointment->slot_id);
                        $startDate = $startTime = $endTime = "Unknown";
                        $upComming = 0;
                        $isLocked = $servicesBooking->is_locked;
                        if ($calendar) {
                            $upComming = (Carbon::now() > Carbon::parse($calendar->start_date)) ? 0 : 1;
                            $startDate = $calendar->start_date;
                            $startTime = Carbon::parse($calendar->start_date)->format('g:i A');
                            $endTime = Carbon::parse($calendar->end_date)->format('g:i A');
                            $now = Carbon::now();
                            $beforeStartDay = Carbon::parse($calendar->start_date)->subDays(1);
                            $afterStartDay = Carbon::parse($calendar->start_date)->addDays(1);
                            if ($now >= $beforeStartDay && $now <= $afterStartDay) {
                                $isLocked = 0;
                            }

                        }
                        $payLoad = [
                            "id" => $serviceAppointment->id,
                            "service_type" => $service->type,
                            "service_name" => $service->full_name,
                            "service_image" => $service->profile_picture_path,
                            "customer_name" => "{$customer->first_name} {$customer->middle_name} {$customer->last_name}",
                            "upcoming" => $upComming,
                            "start_date" => $startDate,
                            "start_time" => $startTime,
                            "end_time" => $endTime,
                            "isLocked" => $isLocked,
                        ];
                        //one and package
                    } elseif ($service->type == 1 || $service->type == 2) {
                        $calendar = ServicesCalendar::find($serviceAppointment->slot_id);
                        $startDate = $startTime = $endTime = "Unknown";
                        $upComming = 0;
                        $isLocked = $servicesBooking->is_locked;
                        if ($calendar) {
                            $upComming = (Carbon::now() > Carbon::parse($calendar->start_date)) ? 0 : 1;
                            $startDate = $calendar->start_date;
                            $startTime = Carbon::parse($calendar->start_date)->format('g:i A');
                            $endTime = Carbon::parse($calendar->end_date)->format('g:i A');
                            $now = Carbon::now();
                            $beforeStartDay = Carbon::parse($calendar->start_date)->subDays(1);
                            $afterStartDay = Carbon::parse($calendar->start_date)->addDays(1);
                            if ($now >= $beforeStartDay && $now <= $afterStartDay) {
                                $isLocked = 0;
                            }

                        }
                        $payLoad = [
                            "id" => $serviceAppointment->id,
                            "service_type" => $service->type,
                            "service_name" => $service->name_en,
                            "service_image" => $service->profile_picture_path,
                            "customer_name" => "{$customer->first_name} {$customer->middle_name} {$customer->last_name}",
                            "upcoming" => $upComming,
                            "start_date" => $startDate,
                            "start_time" => $startTime,
                            "end_time" => $endTime,
                            "isLocked" => $isLocked,
                        ];
                    }
                } elseif ($serviceBookingLaps != null) {
                    $calendar = LapCalendar::find($serviceAppointment->slot_id);
                    $startDate = $startTime = $endTime = "Unknown";
                    $upComming = 0;
                    $isLocked = $servicesBooking->is_locked;
                    if ($calendar) {
                        $upComming = (Carbon::now() > Carbon::parse($calendar->start_date)) ? 0 : 1;
                        $startDate = $calendar->start_date;
                        $startTime = Carbon::parse($calendar->start_date)->format('g:i A');
                        $endTime = Carbon::parse($calendar->end_date)->format('g:i A');
                        $now = Carbon::now();
                        $beforeStartDay = Carbon::parse($calendar->start_date)->subDays(1);
                        $afterStartDay = Carbon::parse($calendar->start_date)->addDays(1);
                        if ($now >= $beforeStartDay && $now <= $afterStartDay) {
                            $isLocked = 0;
                        }

                    }
                    $payLoad = [
                        "id" => $serviceAppointment->id,
                        "service_type" => 4,
                        "service_name" => "Lap",
                        "service_image" => Categories::find(2)->profile_picture_path,
                        "customer_name" => "{$customer->first_name} {$customer->middle_name} {$customer->last_name}",
                        "upcoming" => $upComming,
                        "start_date" => $startDate,
                        "start_time" => $startTime,
                        "end_time" => $endTime,
                        "isLocked" => $isLocked,
                    ];
                }
                if ($payLoad["start_date"] != "Unknown") {
                    if ($payLoad["upcoming"] == 1) {
                        $upCommingAppointments[] = $payLoad;
                    } else {
                        $passedAppointments[] = $payLoad;
                    }

                }
            }
        }
        $upCommingAppointments = collect($upCommingAppointments)->sortBy('start_date')->values()->all();
        $passedAppointments = collect($passedAppointments)->sortBy('start_date')->reverse()->values()->all();
        $appointments = collect(array_merge($upCommingAppointments, $passedAppointments));
        $appointments->each(function ($appointment) use (&$finalAppointments) {
            $appointment["start_date"] = Carbon::parse($appointment["start_date"])->format('l jS \\of F Y');
            array_push($finalAppointments, $appointment);
        });
        return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([
            "bookings" => $finalAppointments,
            "max_pages" => $servicesBookingsMaxPages
        ]));
    }

    public function getBooking(Request $request, $id, $serviceType)
    {
        $appointment = ServiceBookingAppointment::find($id);
        $calendar = [];
        $services = [];
        $totalBeforeTax = 0;
        $serviceBooking = ServiceBooking::find($appointment->service_booking_id);
        $customer = $serviceBooking->customer;
        $vat = ($customer->is_saudi_nationality) ? 0 : config('constants.vat_percentage');
        $promoCode = ($serviceBooking->promo_code != null) ? $serviceBooking->promo_code->code : "";
        $currency = $serviceBooking->currency->name_eng;
        $total = $serviceBooking->price;
        if ($serviceType == 5) {
            $providersCalendar = ProvidersCalendar::find($appointment->slot_id);
            if ($providersCalendar) {
                $providerService = $serviceBooking->provider;
                $calendar[] = ApiHelpers::reBuildCalendarSlot($providersCalendar);
                $totalBeforeTax = $providerService->price;
            }
        } elseif ($serviceType == 1 || $serviceType == 2) {
            $servicesCalendar = ServicesCalendar::find($appointment->slot_id);
            if ($servicesCalendar) {
                $calendar[] = ApiHelpers::reBuildCalendarSlot($servicesCalendar);
                $totalBeforeTax = $serviceBooking->service->price;
            }
        } elseif ($serviceType == 4) {
            $lapClendar = LapCalendar::find($appointment->slot_id);
            if ($lapClendar) {
                $calendar[] = ApiHelpers::reBuildCalendarSlot($lapClendar);
                $servicesLap = ServiceBookingLap::where('service_booking_id', $serviceBooking->id)->get();
                foreach ($servicesLap as $serviceLap) {
                    $totalBeforeTax += $serviceLap->service->price;
                }
            }
        }
        if (!$serviceBooking->invoice) {
            $invoiceClass = new InvoiceClass();
            $invoice = $invoiceClass->createNewInvoice($serviceBooking);
        } else {
            $invoice = $serviceBooking->invoice;
        }
        $invoiceItems = $invoice->items;
        foreach ($invoiceItems as $invoiceItem) {
            $service = $invoiceItem->service;
            if (empty($service)) {
                $service = $invoiceItem->provider;
                $service->name = $service->full_name;
            }
            $service = [
                "id" => $invoiceItem->id,
                "name" => $service->name,
                "price" => $service->price,
                "status" => $invoiceItem->status,
                "visit_duration" => $service->visit_duration,
            ];
            $services[] = $service;
        }
        return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([
            "customer_picture" => Utilities::getFileUrl($customer->profile_picture_path),
            "customer_name" => "{$customer->first_name} {$customer->middle_name} {$customer->last_name}",
            "customer_number" => $customer->mobile_number,
            "customer_address" => $serviceBooking->address,
            "calendar" => $calendar,
            "services" => $services,
            "promo_code" => $promoCode,
            "currency" => $currency,
            "total_before_tax" => $totalBeforeTax,
            "vat" => $vat,
            "total" => $total,
            "invoice_id" => $invoice->id,
            "is_paid" => $serviceBooking->invoice->is_paid,
            "booking_status" => $serviceBooking->status,
        ]));

    }

    public function requestUnlockBooking(Request $request, $id)
    {
        $appointment = ServiceBookingAppointment::find($id);
        $booking = ServiceBooking::find($appointment->service_booking_id);
        $booking->unlock_request = 1;
        $booking->save();
        return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([
        ]));
    }

    public function getBookingQuestionnaireAnswer(Request $request, $id, $page)
    {
        $pagesCount = ServiceBookingAnswers::where('service_booking_id', $id)->max('pagination');
        $questionnaire = ServiceBookingAnswers::where([['service_booking_id', $id], ['pagination', $page]])->get();
        $questionnaire->each(function ($questionnaire) {
            $answer = $questionnaire->answer;
            $questionnaire->options_ar = empty(unserialize($questionnaire->options_ar)) ? [] : unserialize($questionnaire->options_ar);
            $questionnaire->options_en = empty(unserialize($questionnaire->options_en)) ? [] : unserialize($questionnaire->options_en);
            $questionnaire->answer = empty(unserialize($answer)) ? "" : unserialize($answer);
            $questionnaire->answerArray = empty(unserialize($answer)) ? [] : unserialize($answer);
            if($questionnaire->type == 0 || $questionnaire->type == 1)
            $questionnaire->answer = "";
            else
            $questionnaire->answerArray = [];
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

    public function getApprovedReports(Request $request, $id)
    {
        $medicalReports = [];
        $appointment = ServiceBookingAppointment::find($id);
        $booking = ServiceBooking::find($appointment->service_booking_id);
        $reports = $booking->load(['medicalReports' => function ($query) {
            $query->where('is_approved', 1);
        }])->medicalReports;
        $reports->each(function ($report) use (&$medicalReports) {
            $report->title = $report->medicalReport->title_en;
            $report->category = "";
            $report->filled_file_path = Utilities::getFileUrl($report->file_path);
            array_push($medicalReports, $report);
        });
        return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([
            "reports" => $medicalReports,
        ]));
    }

    public function joinUs(Request $request)
    {
        $fullName = $request->input('full_name');
        $email = $request->input('email');
        $mobile = $request->input('mobile_number');
        $nationalId = $request->input('national_id');
        $speciality = $request->input('speciality');
        $cityId = $request->input('city_id');
        $joinUs = new JoinUs();
        $joinUs->full_name = $fullName;
        $joinUs->email = $email;
        $joinUs->mobile_number = $mobile;
        $joinUs->national_id = $nationalId;
        $joinUs->city_id = $cityId;
        $joinUs->speciality = $speciality;
        $joinUs->save();
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([]));
    }

    public function editProfile(Request $request)
    {
        $provider = Auth::user();
        $provider->title_ar = $request->input('title_ar');
        $provider->title_en = $request->input('title_en');
        $provider->first_name_ar = $request->input('first_name_ar');
        $provider->first_name_en = $request->input('first_name_en');
        $provider->last_name_ar = $request->input('last_name_ar');
        $provider->last_name_en = $request->input('last_name_en');
        $provider->email = $request->input('email');
        $provider->mobile_number = $request->input('mobile_number');
        $provider->speciality_area_ar = $request->input('speciality_area_ar');
        $provider->speciality_area_en = $request->input('speciality_area_en');
        $provider->video = $request->input('video');
        $provider->about_ar = $request->input('about_ar');
        $provider->about_en = $request->input('about_en');
        $provider->experience_ar = $request->input('experience_ar');
        $provider->experience_en = $request->input('experience_en');
        $provider->education_ar = $request->input('education_ar');
        $provider->education_en = $request->input('education_en');
        $provider->save();
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([]));
    }

    public function updateInvoicePromocode(Request $request)
    {
        $promoCodes = new PromoCodes();
        return $promoCodes->registerPromoCode($request);
    }

    public function confirmInvoice(Request $request, $bookingId)
    {
        $priceBeforeTax = $request->input('price_before_tax', null);
        $promoCode = $request->input('promo_code', null);
        $promoCodeData = PromoCode::where('code', $promoCode)->first();
        $promoCodeId = null;
        $appointment = ServiceBookingAppointment::find($bookingId);
        $booking = ServiceBooking::find($appointment->service_booking_id);
        if ($promoCodeData) {
            $booking->promo_code_id = $promoCodeData->id;
            $vat = 0;
            if (!$booking->customer->is_saudi_nationality) {
                $vat = config('constants.vat_percentage');
            }

            $priceAfterTax = $priceBeforeTax + Utilities::calcPercentage($priceBeforeTax, $vat);
            $totalPrice = $priceAfterTax - Utilities::calcPercentage($priceAfterTax, $promoCodeData->discount_percentage);
            $booking->price = $totalPrice;
            $booking->save();
        }
        // update invoice
        $add = $booking->invoice;
        $add->service_booking_id = $booking->id;
        $add->customer_id = $booking->customer_id;
        //login Provider ID
        if (auth()->guard('provider-web')->user()) {
            $add->provider_id = auth()->guard('provider-web')->user()->id;
        }
        $add->currency_id = $booking->currency_id;
        $add->is_saudi_nationality = $booking->customer->is_saudi_nationality;
        $add->invoice_code = config('constants.invoice_code') . $booking->id;
        $add->admin_comment = $booking->admin_comment;
        $add->save();
        $items = BookingServicesController::getBookingDetails($booking);
        $invoiceClass = new InvoiceClass();
        //Calculate amount of this invoice
        if ($items['original_amount']) {
            $amount = $invoiceClass->calculateInvoiceServicePrice($items['original_amount'], $items['promo_code_percentage'], $items['vat_percentage']);
            if (!empty($amount)) {
                $invoiceClass->updateInvoiceAmount($add, $amount['amount_original'], $amount['amount_after_discount'], $amount['amount_after_vat'], $amount['amount_final']);
            }
        }
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([]));
    }

    public function getInvoice(Request $request, $bookingId, $serviceType)
    {
        $appointment = ServiceBookingAppointment::find($bookingId);
        $calendar = [];
        $services = [];
        $totalBeforeTax = 0;
        $serviceBooking = ServiceBooking::find($appointment->service_booking_id);
        $customer = $serviceBooking->customer;
        $vat = ($customer->is_saudi_nationality) ? 0 : config('constants.vat_percentage');
        $promoCode = ($serviceBooking->promo_code != null) ? $serviceBooking->promo_code->code : "";
        $currency = $serviceBooking->currency->name_eng;
        $total = $serviceBooking->price;
        $invoiceItems = $serviceBooking->invoice->items;
        if ($serviceType == 5) {
            $providersCalendar = ProvidersCalendar::find($appointment->slot_id);
            if ($providersCalendar) {
                $providerService = $serviceBooking->provider;
                $calendar[] = ApiHelpers::reBuildCalendarSlot($providersCalendar);
                $totalBeforeTax = $providerService->price;
            }
        } elseif ($serviceType == 1 || $serviceType == 2) {
            $servicesCalendar = ServicesCalendar::find($appointment->slot_id);
            if ($servicesCalendar) {
                $calendar[] = ApiHelpers::reBuildCalendarSlot($servicesCalendar);
                $totalBeforeTax = $serviceBooking->service->price;
            }
        } elseif ($serviceType == 4) {
            $lapClendar = LapCalendar::find($appointment->slot_id);
            if ($lapClendar) {
                $calendar[] = ApiHelpers::reBuildCalendarSlot($lapClendar);
                $servicesLap = ServiceBookingLap::where('service_booking_id', $serviceBooking->id)->get();
                foreach ($servicesLap as $serviceLap) {
                    $totalBeforeTax += $serviceLap->service->price;
                }
            }
        }
        foreach ($invoiceItems as $invoiceItem) {
            $service = $invoiceItem->service;
            if (empty($service)) {
                $service = $invoiceItem->provider;
                $service->name = $service->full_name;
            }
            if ($invoiceItem->status == config('constants.items.pending')) {
                return Utilities::getValidationError(config('constants.responseStatus.operationFailed'),
                    new MessageBag([
                        "message" => trans('errors.errorItemNotConfirmed'),
                    ]));
            }

            $service = [
                "id" => $invoiceItem->id,
                "name" => $service->name,
                "price" => $service->price,
                "status" => $invoiceItem->status,
                "visit_duration" => $service->visit_duration,
            ];
            $services[] = $service;
        }
        return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([
            "customer_picture" => Utilities::getFileUrl($customer->profile_picture_path),
            "customer_name" => "{$customer->first_name} {$customer->middle_name} {$customer->last_name}",
            "customer_number" => $customer->mobile_number,
            "customer_address" => $serviceBooking->address,
            "calendar" => $calendar,
            "services" => $services,
            "promo_code" => $promoCode,
            "currency" => $currency,
            "total_before_tax" => $totalBeforeTax,
            "vat" => $vat,
            "total" => $total,
            "invoice_id" => $serviceBooking->invoice->id,
            "is_paid" => $serviceBooking->invoice->is_paid,
            "booking_status" => $serviceBooking->status,
        ]));
    }

    public function getItemsForInvoice(Request $request, $bookingId)
    {

        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([
                "items" => Service::GetItemsServices()->get(),
            ]));
    }

    public function addItemToInvoice(Request $request, $bookingId)
    {
        $appointment = ServiceBookingAppointment::find($bookingId);
        $serviceBooking = ServiceBooking::find($appointment->service_booking_id);
        $invoice = $serviceBooking->invoice;
        $item = Service::findOrFail($request->input('service_id'));

        if (!$invoice) {
            return Utilities::getValidationError(config('constants.responseStatus.operationFailed'),
                new MessageBag([
                    "invoice not found",
                ]));
        }

//        Save new pending item to invoice
        $invoiceClass = new InvoiceClass();
        $invoice_item = $invoiceClass->saveInvoiceItem($invoice->id, $item->name_en, $item->id, null, config('constants.items.pending'), $item->price);

        if (!$invoice_item) {
            return Utilities::getValidationError(config('constants.responseStatus.operationFailed'),
                new MessageBag([
                    "unable to add item",
                ]));
        }

        //        Now calculate invoice amount
        $invoiceClass = new InvoiceClass();
        $booking = BookingServicesController::getBookingDetails($invoice->booking_service);
        $amount = $invoiceClass->calculateInvoiceServicePrice($invoice->amount_original, $booking['promo_code_percentage'], $booking['vat_percentage'], $item->price);
        $updated_invoice = $invoiceClass->updateInvoiceAmount($invoice, $amount['amount_original'], $amount['amount_after_discount'], $amount['amount_after_vat'], $amount['amount_final']);

        $customer = $updated_invoice->customer;
        //        TODO send notification to customer to approve new item added to invoice
        $payload = PushNotificationsTypes::find(config('constants.pushTypes.addItemToInvoice'));
        $payload->item_id = $invoice_item->id;
        $payload->send_at = Carbon::now()->format('Y-m-d H:m:s');
        $customer->notify(new AddItemToInvoice($payload));
        PushNotificationEventListener::fireOnModel(config('constants.customer_message_cloud'), $customer);
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([]));
    }

    public function deleteItemFromInvoice(Request $request, $bookingId)
    {
        $invoice_item = InvoiceItems::findOrFail($request->input('invoice_item_id'));

//        Now calculate invoice amount
        $invoiceClass = new InvoiceClass();
        $booking = BookingServicesController::getBookingDetails($invoice_item->invoice->booking_service);
        $amount = $invoiceClass->calculateInvoiceServicePrice($invoice_item->invoice->amount_original, $booking['promo_code_percentage'], $booking['vat_percentage'], $invoice_item->service->price, 'Delete');
        $updated_invoice = $invoiceClass->updateInvoiceAmount($invoice_item->invoice, $amount['amount_original'], $amount['amount_after_discount'], $amount['amount_after_vat'], $amount['amount_final']);

//        Now Delete this item
        $invoice_item->delete();
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([]));
    }

    public function payInvoice(Request $request, $bookingId)
    {
//        Now update invoice to be paid
        $invoice = Invoice::findOrFail($request->input('invoice_id'));
        $unConfirmedItems = $invoice->items()->where('status', 1)->get();
        if (!$unConfirmedItems->isEmpty()) {
            return Utilities::getValidationError(config('constants.responseStatus.operationFailed'),
                new MessageBag([
                    "please confirm or delete unconfirmed items",
                ]));
        }

        $booking = $invoice->booking_service;
        $booking->status = config('constants.bookingStatus.confirmed');
        $booking->status_desc = "finished";
        $booking->save();

        $invoice->update([
            'is_paid' => 1,
            'payment_method' => $request->input('payment_method'),
            'payment_transaction_number' => $request->input('payment_transaction_number', null),
            'provider_comment' => $request->input('provider_comment', ""),
        ]);
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([]));
    }

    public function getDrivers(Request $request)
    {
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([
                "drivers" => Driver::where('status', 1)->get(),
            ]));
    }

    public function bindDriverToAppointment(Request $request, $bookingId)
    {
        $driverTrip = new DriverTrips();
        $driverTrip->driver_id = $request->input('driver_id');
        $driverTrip->appointment_id = $bookingId;
        $driverTrip->comment = $request->input('comment', '');
        $driverTrip->save();
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([]));
    }

    public function getProviderNotifications(Request $request, $page = 1)
    {
        $page -= 1;
        $notificationsMaxPages = ceil(Auth::user()->notifications()->where('is_pushed', 1)->count()/config('constants.paggination_items_per_page'));
        $notifications = Auth::user()->notifications()->where('is_pushed', 1)
            ->skip($page * config('constants.paggination_items_per_page'))->take(config('constants.paggination_items_per_page'))->get();
        $returnNotifications = [];
        foreach ($notifications as $notification) {
            $notificationData = json_decode(json_encode($notification->data));
            $data = new \StdClass();
            $data->title = $notificationData->{'title_' . App::getLocale()};
            $data->description = $notificationData->{'desc_' . App::getLocale()};
            $data->notification_type = $notificationData->notification_type;
            if (isset($notificationData->service_type)) {
                $data->service_type = $notificationData->service_type;
            }

            $data->related_id = $notificationData->related_id;
            $data->send_at = $notificationData->send_at;
            $data->is_read = ($notification->read_at == null) ? 0 : 1;
            array_push($returnNotifications, $data);
        }
        $notifications->markAsRead();
        return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([
            "notifications" => $returnNotifications,
            "max_pages" => $notificationsMaxPages
        ]));
    }

    public function getCloseBookings(Request $request, $page = 1)
    {
        $appointments = [];
        $finalAppointments = [];
        $page -= 1;
        $servicesBookingsMaxPages = ceil(Auth::user()->load(['servicesBookings.service_appointments' => function ($query) {
            $query->orderByRaw('service_booking_appointments.created_at DESC');
        }])->servicesBookings()->count()/config('constants.paggination_items_per_page'));
        $servicesBookings = Auth::user()->load(['servicesBookings.service_appointments' => function ($query) {
            $query->orderByRaw('service_booking_appointments.created_at DESC');
        }])->servicesBookings()->whereRaw('service_bookings.status = 1')->skip($page * config('constants.paggination_items_per_page'))->take(config('constants.paggination_items_per_page'))->get();
        foreach ($servicesBookings as $servicesBooking) {
            $service = null;
            $serviceBookingLaps = null;
            $serviceId = $servicesBooking->service_id;
            if ($serviceId != null) {
                $service = Service::find($serviceId);
            } elseif ($serviceId == null && $servicesBooking->provider_id != null && $servicesBooking->is_lap == 0) {
                $service = $servicesBooking->provider;
                $service->type = 5;
            } else {
                $serviceBookingLaps = ServiceBookingLap::with('service')->where('service_booking_id', $servicesBooking->id)->get();
            }
            $serviceAppointments = $servicesBooking->service_appointments;
            $customer = $servicesBooking->customer;
            foreach ($serviceAppointments as $serviceAppointment) {
                $payLoad = [];
                if ($service != null) {
                    //provider
                    if ($service->type == 5) {
                        dd($serviceAppointment->slot_id);
                        $calendar = ProvidersCalendar::find($serviceAppointment->slot_id);
                        $startDate = $startTime = $endTime = "Unknown";
                        if ($calendar) {
                            $startDate = $calendar->start_date;
                            $startTime = Carbon::parse($calendar->start_date)->format('g:i A');
                            $endTime = Carbon::parse($calendar->end_date)->format('g:i A');
                            $now = Carbon::now();
                            $nowPlusHours = Carbon::now()->addHours(10);
                            $afterStartDay = Carbon::parse($calendar->start_date);
                            if (!($now <= $afterStartDay && $nowPlusHours >= $afterStartDay)) {
                                $startDate = "Unknown";
                            }
                        }
                        $payLoad = [
                            "id" => $serviceAppointment->id,
                            "service_type" => $service->type,
                            "service_name" => $service->full_name,
                            "service_image" => $service->profile_picture_path,
                            "start_date" => $startDate,
                            "start_time" => $startTime,
                            "end_time" => $endTime,
                            "customer_name" => "{$customer->first_name} {$customer->middle_name} {$customer->last_name}",
                            "customer_image" => Utilities::getFileUrl($customer->profile_picture_path),
                            "customer_mobile" => $customer->mobile_number,
                            "customer_position" => $customer->position
                        ];
                        //one and package
                    } elseif ($service->type == 1 || $service->type == 2) {
                        $calendar = ServicesCalendar::find($serviceAppointment->slot_id);
                        $startDate = $startTime = $endTime = "Unknown";
                        if ($calendar) {
                            $startDate = $calendar->start_date;
                            $startTime = Carbon::parse($calendar->start_date)->format('g:i A');
                            $endTime = Carbon::parse($calendar->end_date)->format('g:i A');
                            $now = Carbon::now();
                            $nowPlusHours = Carbon::now()->addHours(10);
                            $afterStartDay = Carbon::parse($calendar->start_date);
                            if (!($now <= $afterStartDay && $nowPlusHours >= $afterStartDay)) {
                                $startDate = "Unknown";
                            }
                        }
                        $payLoad = [
                            "id" => $serviceAppointment->id,
                            "service_type" => $service->type,
                            "service_name" => $service->name_en,
                            "service_image" => $service->profile_picture_path,
                            "start_date" => $startDate,
                            "start_time" => $startTime,
                            "end_time" => $endTime,
                            "customer_name" => "{$customer->first_name} {$customer->middle_name} {$customer->last_name}",
                            "customer_image" => Utilities::getFileUrl($customer->profile_picture_path),
                            "customer_mobile" => $customer->mobile_number,
                            "customer_position" => $customer->position
                        ];
                    }
                } elseif ($serviceBookingLaps != null) {
                    $calendar = LapCalendar::find($serviceAppointment->slot_id);
                    $startDate = $startTime = $endTime = "Unknown";
                    if ($calendar) {
                        $startDate = $calendar->start_date;
                        $startTime = Carbon::parse($calendar->start_date)->format('g:i A');
                        $endTime = Carbon::parse($calendar->end_date)->format('g:i A');
                        $now = Carbon::now();
                        $nowPlusHours = Carbon::now()->addHours(10);
                        $afterStartDay = Carbon::parse($calendar->start_date);
                        if (!($now <= $afterStartDay && $nowPlusHours >= $afterStartDay)) {
                            $startDate = "Unknown";
                        }
                    }
                    $payLoad = [
                        "id" => $serviceAppointment->id,
                        "service_type" => 4,
                        "service_name" => "Lap",
                        "service_image" => Categories::find(2)->profile_picture_path,
                        "start_date" => $startDate,
                        "start_time" => $startTime,
                        "end_time" => $endTime,
                        "customer_name" => "{$customer->first_name} {$customer->middle_name} {$customer->last_name}",
                        "customer_image" => Utilities::getFileUrl($customer->profile_picture_path),
                        "customer_mobile" => $customer->mobile_number,
                        "customer_position" => $customer->position
                    ];
                }
                if ($payLoad["start_date"] != "Unknown") {
                    $appointments[] = $payLoad;
                }
            }
        }
        $appointments = collect($appointments);
        $appointments->each(function ($appointment) use (&$finalAppointments) {
            $appointment["start_date"] = Carbon::parse($appointment["start_date"])->format('l jS \\of F Y');
            array_push($finalAppointments, $appointment);
        });
        return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([
            "bookings" => $finalAppointments,
            "max_pages" => $servicesBookingsMaxPages
        ]));
    }
}
