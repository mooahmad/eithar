<?php

namespace App\Http\Services\WebApi\ClassesUsers;

use App\Helpers\ApiHelpers;
use App\Http\Services\WebApi\UsersModule\AbstractUsers\customer;
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
}