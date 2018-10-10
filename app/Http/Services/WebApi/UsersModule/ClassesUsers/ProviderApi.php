<?php

namespace App\Http\Services\WebApi\ClassesUsers;

use App\Helpers\ApiHelpers;
use App\Http\Services\WebApi\UsersModule\AbstractUsers\Provider;
use Illuminate\Http\Request;

class ProviderApi extends Provider
{
    public function getProvider($request, $providerId)
    {
        $validationObject = parent::getProvider($request, $providerId);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function likeProvider($request, $providerId)
    {
        $validationObject = parent::likeProvider($request, $providerId);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function getBookingAvailableReports($request, $bookingId)
    {
        $validationObject = parent::getBookingAvailableReports($request, $bookingId);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function getBookingReportQuestions($request, $reportId, $page = 1)
    {
        $validationObject = parent::getBookingReportQuestions($request, $reportId, $page);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function addBookingReport(Request $request, $bookingId)
    {
        $validationObject = parent::addBookingReport($request, $bookingId);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function unlikeProvider($request, $providerId)
    {
        $validationObject = parent::unlikeProvider($request, $providerId);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function followProvider($request, $providerId)
    {
        $validationObject = parent::followProvider($request, $providerId);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function unFollowProvider($request, $providerId)
    {
        $validationObject = parent::unFollowProvider($request, $providerId);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function rateProvider($request, $providerId)
    {
        $validationObject = parent::rateProvider($request, $providerId);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function reviewProvider($request, $providerId)
    {
        $validationObject = parent::reviewProvider($request, $providerId);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function viewProvider($request, $providerId)
    {
        $validationObject = parent::viewProvider($request, $providerId);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function logoutProvider(Request $request)
    {
        $validationObject = parent::logoutProvider($request);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }
}