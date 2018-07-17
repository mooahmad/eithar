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
        switch ($validationObject->error) {
            case config('constants.responseStatus.missingInput'):
                return ApiHelpers::fail(config('constants.responseStatus.missingInput'), $validationObject->errorMessages);
                break;
            case config('constants.responseStatus.operationFailed'):
                return ApiHelpers::fail(config('constants.responseStatus.operationFailed'), $validationObject->errorMessages);
                break;
            default:
                return ApiHelpers::success(config('constants.responseStatus.success'), $validationObject->errorMessages);
        }
    }

}