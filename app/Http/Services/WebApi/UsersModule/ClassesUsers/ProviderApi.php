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

    public function forgetPassword(Request $request)
    {
        $validationObject = parent::forgetPassword($request);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function updateForgottenPassword(Request $request)
    {
        $validationObject = parent::updateForgottenPassword($request);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function getBookings(Request $request, $page = 1, $eitharId = null)
    {
        $validationObject = parent::getBookings($request, $page, $eitharId);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function getBooking(Request $request, $id, $serviceType)
    {
        $validationObject = parent::getBooking($request, $id, $serviceType);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function requestUnlockBooking(Request $request, $id)
    {
        $validationObject = parent::requestUnlockBooking($request, $id);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function getBookingQuestionnaireAnswer(Request $request, $id, $page = 1)
    {
        $validationObject = parent::getBookingQuestionnaireAnswer($request, $id, $page);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function getApprovedReports(Request $request, $id)
    {
        $validationObject = parent::getApprovedReports($request, $id);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function joinUs(Request $request)
    {
        $validationObject = parent::joinUs($request);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function editProfile(Request $request)
    {
        $validationObject = parent::editProfile($request);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function updateInvoicePromocode(Request $request)
    {
        $validationObject = parent::updateInvoicePromocode($request);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function confirmInvoice(Request $request, $bookingId)
    {
        $validationObject = parent::confirmInvoice($request, $bookingId);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function getInvoice(Request $request, $bookingId, $serviceType)
    {
        $validationObject = parent::getInvoice($request, $bookingId, $serviceType);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function getItemsForInvoice(Request $request, $bookingId)
    {
        $validationObject = parent::getItemsForInvoice($request, $bookingId);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function deleteItemFromInvoice(Request $request, $bookingId)
    {
        $validationObject = parent::deleteItemFromInvoice($request, $bookingId);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function addItemToInvoice(Request $request, $bookingId)
    {
        $validationObject = parent::addItemToInvoice($request, $bookingId);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function payInvoice(Request $request, $bookingId)
    {
        $validationObject = parent::payInvoice($request, $bookingId);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function getDrivers(Request $request)
    {
        $validationObject = parent::getDrivers($request);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function bindDriverToAppointment(Request $request, $bookingId)
    {
        $validationObject = parent::bindDriverToAppointment($request, $bookingId);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function getProviderNotifications(Request $request, $page = 1)
    {
        $validationObject = parent::getProviderNotifications($request, $page);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }
}