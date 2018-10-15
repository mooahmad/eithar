<?php

namespace App\Http\Controllers\WebApi\UsersModule;

use App\Helpers\ApiHelpers;
use App\Http\Services\WebApi\ClassesUsers\ProviderStrategy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProviderController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getProvider(Request $request, $providerId)
    {
        $provider = new ProviderStrategy(ApiHelpers::requestType($request));
        return $provider->getProvider($request, $providerId);
    }

    public function like(Request $request, $providerId)
    {
        $provider = new ProviderStrategy(ApiHelpers::requestType($request));
        return $provider->likeProvider($request, $providerId);
    }

    public function unlike(Request $request, $providerId)
    {
        $provider = new ProviderStrategy(ApiHelpers::requestType($request));
        return $provider->unlikeProvider($request, $providerId);
    }

    public function follow(Request $request, $providerId)
    {
        $provider = new ProviderStrategy(ApiHelpers::requestType($request));
        return $provider->followProvider($request, $providerId);
    }

    public function unFollow(Request $request, $providerId)
    {
        $provider = new ProviderStrategy(ApiHelpers::requestType($request));
        return $provider->unFollowProvider($request, $providerId);
    }

    public function rate(Request $request, $providerId)
    {
        $provider = new ProviderStrategy(ApiHelpers::requestType($request));
        return $provider->rateProvider($request, $providerId);
    }

    public function review(Request $request, $providerId)
    {
        $provider = new ProviderStrategy(ApiHelpers::requestType($request));
        return $provider->reviewProvider($request, $providerId);
    }

    public function view(Request $request, $providerId)
    {
        $provider = new ProviderStrategy(ApiHelpers::requestType($request));
        return $provider->viewProvider($request, $providerId);
    }

    public function getBookingAvailableReports(Request $request, $bookingId)
    {
        $provider = new ProviderStrategy(ApiHelpers::requestType($request));
        return $provider->getBookingAvailableReports($request, $bookingId);
    }

    public function getBookingReportQuestions(Request $request, $reportId, $page = 1)
    {
        $provider = new ProviderStrategy(ApiHelpers::requestType($request));
        return $provider->getBookingReportQuestions($request, $reportId, $page);
    }

    public function addBookingReport(Request $request, $bookingId)
    {
        $provider = new ProviderStrategy(ApiHelpers::requestType($request));
        return $provider->addBookingReport($request, $bookingId);
    }

    public function logoutProvider(Request $request)
    {
        // instantiate login strategy object using request type detection helper method
        $providerStrategy = new ProviderStrategy(ApiHelpers::requestType($request));
        return $providerStrategy->logoutProvider($request);
    }

    public function forgetPassword(Request $request)
    {
        $providerStrategy = new ProviderStrategy(ApiHelpers::requestType($request));
        return $providerStrategy->forgetPassword($request);
    }

    public function updateForgottenPassword(Request $request)
    {
        $providerStrategy = new ProviderStrategy(ApiHelpers::requestType($request));
        return $providerStrategy->updateForgottenPassword($request);
    }

    public function getBookings(Request $request, $eitharId = null)
    {
        // instantiate login strategy object using request type detection helper method
        $providerStrategy = new ProviderStrategy(ApiHelpers::requestType($request));
        return $providerStrategy->getBookings($request, $eitharId);
    }

    public function getBooking(Request $request, $id, $serviceType)
    {
        // instantiate login strategy object using request type detection helper method
        $providerStrategy = new ProviderStrategy(ApiHelpers::requestType($request));
        return $providerStrategy->getBooking($request, $id, $serviceType);
    }

    public function requestUnlockBooking(Request $request, $id)
    {
        $providerStrategy = new ProviderStrategy(ApiHelpers::requestType($request));
        return $providerStrategy->requestUnlockBooking($request, $id);
    }

    public function getBookingQuestionnaireAnswer(Request $request, $id, $page = 1)
    {
        $providerStrategy = new ProviderStrategy(ApiHelpers::requestType($request));
        return $providerStrategy->getBookingQuestionnaireAnswer($request, $id, $page);
    }

}
