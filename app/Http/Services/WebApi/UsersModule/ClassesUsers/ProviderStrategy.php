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

}