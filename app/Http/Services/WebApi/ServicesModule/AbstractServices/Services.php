<?php

namespace App\Http\Services\WebApi\ServicesModule\AbstractServices;

use App\Helpers\Utilities;
use App\Http\Services\WebApi\CommonTraits\Follows;
use App\Http\Services\WebApi\CommonTraits\Likes;
use App\Http\Services\WebApi\CommonTraits\Ratings;
use App\Http\Services\WebApi\CommonTraits\Reviews;
use App\Http\Services\WebApi\CommonTraits\Views;
use App\Http\Services\WebApi\ServicesModule\IServices\IService;
use App\Models\Questionnaire;
use App\Models\Service;
use App\Models\ServiceBooking;
use App\Models\ServiceBookingAnswers;
use Illuminate\Support\Facades\Auth;
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

    public function book($request, $serviceId)
    {
        // service booking table
        $isLap = $request->input('is_lap');
        $providerId = $request->input('provider_id');
        $providerAssignedId = $request->input('provider_assigned_id');
        $serviceId = $request->input('service_id');
        $promoCodeId = $request->input('promo_code_id');
        $price = $request->input('price');
        $currencyId = $request->input('currency_id');
        $comment = $request->input('comment', '');
        $address = $request->input('address', '');
        $familyMemberId = $request->input('family_member_id', null);
        $status = $request->input('status');
        $statusDescription = $request->input('status_description', '');
        $serviceBookingId = $this->saveServiceBooking($isLap, $providerId, $providerAssignedId, $serviceId, $promoCodeId, $price, $currencyId, $comment, $address, $familyMemberId, $status, $statusDescription);
        // service booking answers table
        $serviceQuestionnaireIds = $request->input('service_questionnaire_id');
//        $questionType = $request->input('question_type');
//        $questionTitleAr = $request->input('question_title_ar');
//        $questionTitleEn = $request->input('question_title_en');
//        $questionSubtitleAr = $request->input('question_subtitle_ar');
//        $questionSubtitleEn = $request->input('question_subtitle_en');
//        $questionOptionsAr = $request->input('question_options_ar');
//        $questionOptionsEn = $request->input('question_options_en');
//        $questionIsRequired = $request->input('question_is_required');
//        $questionRatingLevels = $request->input('question_rating_levels');
//        $questionRatingSymbol = $request->input('question_rating_symbol');
//        $questionPagination = $request->input('question_pagination');
//        $questionOrder = $request->input('question_order');
        $answerTypes = $request->input('answer_type');
        $answers = $request->input('answer');
        $bookingAnswer = $this->saveBookingAnswers($serviceBookingId, $serviceQuestionnaireIds, $answerTypes, $answers);
        // service booking appointments table
        $appointmentDate = $request->input('appointment_date');

    }

    private function saveServiceBooking($isLap, $providerId, $providerAssignedId, $serviceId, $promoCodeId, $price, $currencyId, $comment, $address, $familyMemberId, $status, $statusDescription)
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
        return $booking->id;
    }

    private function saveBookingAnswers($serviceBookingId, $serviceQuestionnaireIds, $answerTypes, $answers)
    {
        $data = [];

        return ServiceBookingAnswers::insert($data);
    }
}