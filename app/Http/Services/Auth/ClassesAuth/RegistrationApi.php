<?php

namespace App\Http\Services\Auth\ClassesAuth;


use App\Helpers\ApiHelpers;
use App\Http\Services\Auth\AbstractAuth\Registration;
use Illuminate\Http\Request;

class RegistrationApi extends Registration
{
    public function registerCustomer(Request $customerData)
    {
        // calls register customer logic from parent class
        $validationObject = parent::registerCustomer($customerData);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

}