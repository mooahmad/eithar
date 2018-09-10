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
use App\Models\ProvidersCalendar;
use App\Models\Questionnaire;
use App\Models\Service;
use App\Models\ServiceBooking;
use App\Models\ServiceBookingAnswers;
use App\Models\ServiceBookingAppointment;
use App\Models\ServiceBookingLap;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class Services implements IService
{
    use Likes, Follows, Views, Ratings, Reviews;

    public static function getCategoryServices($categoryID)
    {
        $services = Service::where('category_id', $categoryID)->get();
        $services = $services->each(function ($service) {
            $service->addHidden([
                'name_en', 'name_ar',
                'desc_en', 'desc_ar'
            ]);
        });
        return $services;
    }

    public function getServiceQuestionnaire($id, $page = 1)
    {
        $id = ($id == 0)? null : $id;
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

    public function getLapCalendar(Request $request)
    {
        $day = $request->input('day', Carbon::today()->format('Y-m-d'));
        $calendar = ProvidersCalendar::where([['provider_id', '=', null], ['start_date', 'like', "%$day%"]])->get();
        $calendar = ApiHelpers::reBuildCalendar($day, $calendar);
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([
                "calendar" => $calendar,
            ]));
    }

    public function book($request, $serviceId)
    {
        // service booking table
        $isLap = ($serviceId == 0)? 1 : 0;
        $serviceId = ($serviceId == 0)? null : $serviceId;
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
        // service booking answers table
        $serviceQuestionnaireAnswers = $request->input('service_questionnaire_answers');
        $bookingAnswer = $this->saveBookingAnswers($serviceBookingId, $serviceQuestionnaireAnswers);
        // service booking appointments table
        $appointmentDate = $request->input('slot_id');
        $this->saveBookingAppointments($serviceBookingId, $appointmentDate);
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([]));
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
        if($serviceId == 0){
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
        foreach($serviceQuestionnaireAnswers as $key => $value) {
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

    private function saveBookingAppointments($serviceBookingId, $appointmentDate)
    {
        $bookingAppointment = new ServiceBookingAppointment();
        $bookingAppointment->service_booking_id = $serviceBookingId;
        $bookingAppointment->slot_id = $appointmentDate;
        return $bookingAppointment->save();
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
}