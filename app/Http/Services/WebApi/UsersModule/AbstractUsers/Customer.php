<?php

namespace App\Http\Services\WebApi\UsersModule\AbstractUsers;


use App\Helpers\ApiHelpers;
use App\Helpers\Utilities;
use App\Http\Requests\Auth\RegisterCustomer;
use App\Http\Requests\Auth\UpdateForgetPasswordRequest;
use App\Http\Requests\Auth\VerifyCustomerEmail;
use App\Http\Services\Auth\AbstractAuth\Registration;
use App\LapCalendar;
use App\Mail\Auth\VerifyEmailCode;
use App\Mail\Customer\ForgetPasswordMail;
use App\Models\ProvidersCalendar;
use App\Models\PushNotification;
use App\Models\Service;
use App\Models\ServiceBooking;
use App\Models\ServiceBookingAppointment;
use App\Models\ServiceBookingLap;
use App\Models\ServicesCalendar;
use App\Notifications\AppointmentConfirmed;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Customer as CustomerModel;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Auth\LoginCustomer;

class Customer
{
    /**
     * @param $customerAvatar
     * @param Customer $customer
     * @return bool
     */
    public function uploadCustomerAvatar(Request $request, $fileName, CustomerModel $customer)
    {
        if ($request->hasFile($fileName)) {
            $isValidImage = Utilities::validateImage($request, $fileName);
            if (!$isValidImage)
                return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                    new MessageBag([
                        "message" => trans('errors.errorUploadAvatar')
                    ]));
            $isUploaded = Utilities::uploadFile($request->file($fileName), 'public/images/avatars');
            if (!$isUploaded)
                return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                    new MessageBag([
                        "message" => trans('errors.errorUploadAvatar')
                    ]));
            Utilities::DeleteFile($customer->profile_picture_path);
            $customer->profile_picture_path = $isUploaded;
            if (!$customer->save())
                return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                    new MessageBag([
                        "message" => trans('errors.errorUploadAvatar')
                    ]));
            return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));
        }
        return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));
    }

    /**
     * @param $nationalIDImage
     * @param Customer $customer
     * @return bool
     */
    public function uploadCustomerNationalIDImage(Request $request, $fileName, CustomerModel $customer)
    {
        if ($request->hasFile($fileName)) {
            $isValidImage = Utilities::validateImage($request, $fileName);
            if (!$isValidImage)
                return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                    new MessageBag([
                        "message" => trans('errors.errorUploadNationalID')
                    ]));
            $isUploaded = Utilities::uploadFile($request->file($fileName), 'public/images/nationalities');
            if (!$isUploaded)
                return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                    new MessageBag([
                        "message" => trans('errors.errorUploadNationalID')
                    ]));
            Utilities::DeleteFile($customer->nationality_id_picture);
            $customer->nationality_id_picture = $isUploaded;
            if (!$customer->save())
                return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                    new MessageBag([
                        "message" => trans('errors.errorUploadNationalID')
                    ]));
            return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));
        }
        return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));
    }

    /**
     * verifies customer data using validator with rules
     * @param Request $request
     * @return bool|\Illuminate\Contracts\Validation\Validator
     */
    public function verifyRegisterCustomerData(Request $request)
    {
        $customerID = null;
        if (Auth::check())
            $customerID = Auth::user()->id;
        $validator = Validator::make($request->all(), (new RegisterCustomer())->rules($customerID));
        if ($validator->fails()) {
            return $validator;
        }
        return true;
    }

    /**
     * verifies customer data using validator with rules
     * @param Request $request
     * @return bool|\Illuminate\Contracts\Validation\Validator
     */
    public function verifyCustomerCredentials(Request $request)
    {
        $validator = Validator::make($request->all(), (new LoginCustomer())->rules());
        if ($validator->fails()) {
            return $validator;
        }
        return true;
    }

    /**
     * @param Customer $newCustomer
     * @param Request $request
     * @return Customer
     */
    public function updateORCreateCustomer(CustomerModel $customer, Request $request, $isCreate = true)
    {
        $customer->first_name = $request->input('first_name');
        $customer->middle_name = $request->input('middle_name');
        $customer->last_name = $request->input('last_name');
        $customer->email = $request->input('email');
        $customer->mobile_number = $request->input('mobile');
        $customer->password = Hash::make($request->input('password'));
        $customer->gender = $request->input('gender');
        $customer->national_id = $request->input('national_id');
        $customer->country_id = $request->input('country_id');
        $customer->city_id = $request->input('city_id');
        $customer->position = $request->input('position');
        $customer->address = $request->input('address');
        if ($isCreate) {
            $customer->email_code = Utilities::quickRandom(4, true);
            $customer->mobile_code = Utilities::quickRandom(4, true);
        }
        return $customer;
    }

    public function updateCustomerToken(CustomerModel $customer, Request $request)
    {
        if ($customer->pushNotification)
            $customer->pushNotification->delete();
        $pushNotification = new PushNotification();
        $pushNotification->customer_id = $customer->id;
        $pushNotification->imei = $request->input('imei');
        $pushNotification->device_type = $request->input('device_type');
        $pushNotification->device_language = $request->input('device_language');
        $pushNotification->token = $request->input('token');
        $pushNotification->save();
    }


    public function editCustomer(Request $request)
    {
        return (new Registration())->registerCustomer($request);

    }

    /**
     * @param CustomerModel $customer
     * @return bool
     */
    public function updateLastLoginDate(CustomerModel $customer)
    {
        $customer->last_login_date = Carbon::now();
        if (!$customer->save())
            return false;
        return true;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function isCustomerExists(Request $request)
    {
        $customer = CustomerModel::where('mobile_number', $request->input('mobile'))->first();
        if (!$customer)
            return false;
        if (!Hash::check($request->input('password'), $customer->password))
            return false;
        return $customer;
    }

    public function verifyCustomerEmail(Request $request)
    {
        $isVerified = $this->validateVerifyCustomerEmail($request);
        if ($isVerified !== true)
            return Utilities::getValidationError(config('constants.responseStatus.missingInput'), $isVerified->errors());
        $customer = CustomerModel::where([['email', $request->input('email')], ['email_code', $request->input('email_code')]])->first();
        if (!$customer)
            return Utilities::getValidationError(config('constants.responseStatus.operationFailed'),
                new MessageBag([
                    "message" => trans('errors.wrongCode')
                ]));
        $customer->email_verified = 1;
        $customer->save();
        return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));
    }

    private function validateVerifyCustomerEmail(Request $request)
    {
        $validator = Validator::make($request->all(), (new VerifyCustomerEmail())->rules());
        if ($validator->fails()) {
            return $validator;
        }
        return true;
    }

    public function resendEmailVerificationCode(Request $request)
    {
        Mail::to(Auth::user()->email)->send(new VerifyEmailCode(CustomerModel::find(Auth::user()->id)));
        return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));
    }

    public function forgetPassword(Request $request)
    {
        $isVerified = $this->validateForgetPassword($request);
        if ($isVerified !== true)
            return Utilities::getValidationError(config('constants.responseStatus.missingInput'), $isVerified->errors());
        $customer = CustomerModel::where('mobile_number', $request->input('mobile'))->first();
        if (!$customer)
            return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));
        $encrytedCode = Utilities::quickRandom(6, true);
        $customer->forget_password_code = $encrytedCode;
        $customer->save();
        Mail::to($customer->email)->send(new ForgetPasswordMail($customer));
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
        if ($isVerified !== true)
            return Utilities::getValidationError(config('constants.responseStatus.missingInput'), $isVerified->errors());
        $customer = CustomerModel::where([['mobile_number', $request->input('mobile')], ['forget_password_code', $request->input('code')]])->first();
        if (!$customer)
            return Utilities::getValidationError(config('constants.responseStatus.userNotFound'),
                new MessageBag([
                    'message' => trans('errors.userNotFound')
                ]));
        $customer->password = Hash::make($request->input('password'));
        $customer->save();
        return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));

    }

    public function getCustomerAppointments(Request $request)
    {
        $appointments = [];
        $servicesBookings = Auth::user()->load(['servicesBooking.service_appointments' => function ($query) {
            $query->orderByRaw('service_booking_appointments.id DESC');
        }])->servicesBooking;
        foreach ($servicesBookings as $servicesBooking) {
            $service = null;
            $serviceBookingLaps = null;
            $serviceId = $servicesBooking->service_id;
            if ($serviceId != null) {
                $service = Service::find($serviceId);
            } else {
                $serviceBookingLaps = ServiceBookingLap::with('service')->where('service_booking_id', $servicesBooking->id)->get();
            }
            $serviceAppointments = $servicesBooking->service_appointments;
            foreach ($serviceAppointments as $serviceAppointment) {
                if ($service != null) {
                    //provider
                    if ($service->type == 5) {
                        $calendar = ProvidersCalendar::find($serviceAppointment->slot_id);
                        $startDate = $startTime = "Unknown";
                        $upComming = 0;
                        if ($calendar) {
                            $upComming = (Carbon::now() > Carbon::parse($calendar->start_date)) ? 0 : 1;
                            $startDate = Carbon::parse($calendar->start_date)->format('l jS \\of F Y');
                            $startTime = Carbon::parse($calendar->start_date)->format('g:i A');
                        }
                        $payLoad = [
                            "id" => $serviceAppointment->id,
                            "service_type" => $service->type,
                            "service_name" => $service->name_en,
                            "upcoming" => $upComming,
                            "start_date" => $startDate,
                            "start_time" => $startTime
                        ];
                        //one and package
                    } elseif ($service->type == 1 || $service->type == 2) {
                        $calendar = ServicesCalendar::find($serviceAppointment->slot_id);
                        $startDate = $startTime = "Unknown";
                        $upComming = 0;
                        if ($calendar) {
                            $upComming = (Carbon::now() > Carbon::parse($calendar->start_date)) ? 0 : 1;
                            $startDate = Carbon::parse($calendar->start_date)->format('l jS \\of F Y');
                            $startTime = Carbon::parse($calendar->start_date)->format('g:i A');
                        }
                        $payLoad = [
                            "id" => $serviceAppointment->id,
                            "service_type" => $service->type,
                            "service_name" => $service->name_en,
                            "upcoming" => $upComming,
                            "start_date" => $startDate,
                            "start_time" => $startTime
                        ];
                    }
                } elseif ($serviceBookingLaps != null) {
                    $calendar = LapCalendar::find($serviceAppointment->slot_id);
                    $startDate = $startTime = "Unknown";
                    $upComming = 0;
                    if ($calendar) {
                        $upComming = (Carbon::now() > Carbon::parse($calendar->start_date)) ? 0 : 1;
                        $startDate = Carbon::parse($calendar->start_date)->format('l jS \\of F Y');
                        $startTime = Carbon::parse($calendar->start_date)->format('g:i A');
                    }
                    $payLoad = [
                        "id" => $serviceAppointment->id,
                        "service_type" => 4,
                        "service_name" => "Lap",
                        "upcoming" => $upComming,
                        "start_date" => $startDate,
                        "start_time" => $startTime
                    ];
                }
                $appointments[] = $payLoad;
            }
        }
        return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([
            "appointments" => $appointments
        ]));
    }

    public function getCustomerAppointment(Request $request, $id, $serviceType)
    {
        $appointment = ServiceBookingAppointment::find($id);
        $calendar = [];
        $services = [];
        $vat = (Auth::user()->is_saudi_nationality) ? 0 : config('constants.vat_percentage');
        $totalBeforeTax = 0;
        $serviceBooking = ServiceBooking::find($appointment->service_booking_id);
        $promoCode = ($serviceBooking->promo_code != null) ? $serviceBooking->promo_code->code : "";
        $currency = $serviceBooking->currency->name_eng;
        $total = $serviceBooking->price;
        if ($serviceType == 5) {
            $calendar[] = ApiHelpers::reBuildCalendarSlot(ProvidersCalendar::find($appointment->slot_id));
            $services [] = $serviceBooking->service;
            $totalBeforeTax = $serviceBooking->service->price;
        } elseif ($serviceType == 1 || $serviceType == 2) {
            $calendar[] = ApiHelpers::reBuildCalendarSlot(ProvidersCalendar::find($appointment->slot_id));
            $services [] = $serviceBooking->service;
            $totalBeforeTax = $serviceBooking->service->price;
        } elseif ($serviceType == 4) {
            $calendar[] = ApiHelpers::reBuildCalendarSlot(ProvidersCalendar::find($appointment->slot_id));
            $servicesLap = ServiceBookingLap::where('service_booking_id', $serviceBooking->id)->get();
            foreach ($servicesLap as $serviceLap) {
                $services [] = $serviceLap->service;
                $totalBeforeTax += $serviceLap->service->price;
            }
        }
        return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([
            "calendar" => $calendar,
            "services" => $services,
            "promo_code" => $promoCode,
            "currency" => $currency,
            "total_before_tax" => $totalBeforeTax,
            "vat" => $vat,
            "total" => $total
        ]));
    }

    private function validateUpdateForgetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), (new UpdateForgetPasswordRequest())->rules());
        if ($validator->fails()) {
            return $validator;
        }
        return true;
    }

    public function getBookedSlots($isLap = false)
    {
        $query = Auth::user()->select('service_booking_appointments.slot_id')
            ->leftJoin('service_bookings', 'customers.id', '=', 'service_bookings.customer_id')
            ->leftJoin('services', 'service_bookings.service_id', '=', 'services.id')
            ->leftJoin('service_booking_appointments', 'service_bookings.id', '=', 'service_booking_appointments.service_booking_id')
            ->where('service_booking_appointments.slot_id', '<>', Null);
        if ($isLap) {
            $query->whereRaw('service_bookings.service_id IS NULL');
        } else
            $query->whereRaw('services.type in (1, 2)');
        return $query->pluck('slot_id')->toArray();
    }

    public function getCustomerNotifications(Request $request)
    {
        $notifications = Auth::user()->notifications;
        $notifications->markAsRead();
        $returnNotifications = [];
        foreach ($notifications as $notification) {
            $notificationData = json_decode(json_encode($notification->data));
            $data = new \StdClass();
            $data->title = $notificationData->{'title_' . App::getLocale()};
            $data->description = $notificationData->{'desc_' . App::getLocale()};
            $data->notification_type = $notificationData->notification_type;
            $data->related_id = $notificationData->related_id;
            $data->is_read = ($notification->read_at != null) ? 1 : 0;
            array_push($returnNotifications, $data);
        }
        return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([
            "notifications" => $returnNotifications
        ]));
    }

    public function getCustomerMedicalReports(Request $request)
    {
        $medicalReports = [];
        $bookings = Auth::user()->servicesBooking;
        $bookings->each(function ($booking) use (&$medicalReports) {
            $reports = $booking->load(['medicalReports' => function ($query) {
                $query->where('is_approved', 1)->where('customer_can_view', 1);
            }])->medicalReports;
            $reports->each(function ($report) use (&$medicalReports) {
                array_push($medicalReports, $report);
            });
        });
        return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([
            "reports" => $medicalReports
        ]));
    }

}