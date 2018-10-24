<?php

namespace App\Http\Services\WebApi\ClassesUsers;

use Illuminate\Http\Request;

class ProviderStrategy
{
    private $strategy = NULL;

    public function __construct($strategyType) {
        switch ($strategyType) {
            case config('constants.requestTypes.web'):
                $this->strategy = new ProviderWeb();
                break;
            case config('constants.requestTypes.api'):
                $this->strategy = new ProviderApi();
                break;
        }
    }

    public function getProvider($request, $providerId)
    {
        return $this->strategy->getProvider($request, $providerId);
    }

    public function likeProvider($request, $providerId)
    {
        return $this->strategy->likeProvider($request, $providerId);
    }

    public function unlikeProvider($request, $providerId)
    {
        return $this->strategy->unlikeProvider($request, $providerId);
    }

    public function followProvider($request, $providerId)
    {
        return $this->strategy->followProvider($request, $providerId);
    }

    public function unFollowProvider($request, $providerId)
    {
        return $this->strategy->unFollowProvider($request, $providerId);
    }

    public function rateProvider($request, $providerId)
    {
        return $this->strategy->rateProvider($request, $providerId);
    }

    public function reviewProvider($request, $providerId)
    {
        return $this->strategy->reviewProvider($request, $providerId);
    }

    public function viewProvider($request, $providerId)
    {
        return $this->strategy->viewProvider($request, $providerId);
    }

    public function getBookingAvailableReports($request, $bookingId)
    {
        return $this->strategy->getBookingAvailableReports($request, $bookingId);
    }

    public function getBookingReportQuestions($request, $reportId, $page)
    {
        return $this->strategy->getBookingReportQuestions($request, $reportId, $page);
    }

    public function addBookingReport($request, $bookingId)
    {
        return $this->strategy->addBookingReport($request, $bookingId);
    }

    public function logoutProvider(Request $request)
    {
        return $this->strategy->logoutProvider($request);
    }

    public function forgetPassword(Request $request)
    {
        return $this->strategy->forgetPassword($request);
    }

    public function updateForgottenPassword(Request $request)
    {
        return $this->strategy->updateForgottenPassword($request);
    }

    public function getBookings(Request $request, $eitharId = null)
    {
        return $this->strategy->getBookings($request, $eitharId);
    }

    public function getBooking(Request $request, $id, $serviceType)
    {
        return $this->strategy->getBooking($request, $id, $serviceType);
    }

    public function requestUnlockBooking(Request $request, $id)
    {
        return $this->strategy->requestUnlockBooking($request, $id);
    }

    public function getBookingQuestionnaireAnswer(Request $request, $id, $page = 1)
    {
        return $this->strategy->getBookingQuestionnaireAnswer($request, $id, $page);
    }

    public function getApprovedReports(Request $request, $id)
    {
        return $this->strategy->getApprovedReports($request, $id);
    }

    public function joinUs(Request $request)
    {
        return $this->strategy->joinUs($request);
    }

    public function editProfile(Request $request)
    {
        return $this->strategy->editProfile($request);
    }

    public function updateInvoicePromocode(Request $request)
    {
        return $this->strategy->updateInvoicePromocode($request);
    }

    public function confirmInvoice(Request $request, $bookingId)
    {
        return $this->strategy->confirmInvoice($request, $bookingId);
    }

    public function getInvoice(Request $request, $bookingId, $serviceType)
    {
        return $this->strategy->getInvoice($request, $bookingId, $serviceType);
    }
}