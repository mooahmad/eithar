<?php

namespace App\Http\Services\WebApi\ClassesUsers;

use App\Helpers\ApiHelpers;
use App\Http\Services\WebApi\UsersModule\AbstractUsers\Customer;
use Illuminate\Http\Request;
use App\Models\Customer as CustomerModel;

class CustomerApi extends Customer
{
    public function uploadCustomerAvatar(Request $request, $fileName, CustomerModel $customer)
    {
        $validationObject = parent::uploadCustomerAvatar($request, $fileName, $customer);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function uploadCustomerNationalIDImage(Request $request, $fileName, CustomerModel $customer)
    {
        $validationObject = parent::uploadCustomerNationalIDImage($request, $fileName, $customer);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function editCustomer(Request $request)
    {
        $validationObject = parent::editCustomer($request);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function verifyCustomerEmail(Request $request)
    {
        $validationObject = parent::verifyCustomerEmail($request);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function resendEmailVerificationCode(Request $request)
    {
        $validationObject = parent::resendEmailVerificationCode($request);
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

    public function getCustomerAppointments(Request $request, $page = 1)
    {
        $validationObject = parent::getCustomerAppointments($request, $page);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function getCustomerAppointment(Request $request, $id, $serviceType)
    {
        $validationObject = parent::getCustomerAppointment($request, $id, $serviceType);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function getCustomerNotifications(Request $request, $page = 1)
    {
        $validationObject = parent::getCustomerNotifications($request, $page);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function getCustomerMedicalReports(Request $request)
    {
        $validationObject = parent::getCustomerMedicalReports($request);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function search(Request $request, $keyword)
    {
        $validationObject = parent::search($request, $keyword);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function logoutCustomer(Request $request)
    {
        $validationObject = parent::logoutCustomer($request);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

}