<?php

namespace App\Http\Services\Auth\ClassesAuth;


use App\Http\Services\Auth\AbstractAuth\Registration;
use Illuminate\Http\Request;

class RegistrationApi extends Registration
{
    public function registerCustomer(Request $customerData)
    {
        $validationObject = parent::registerCustomer($customerData);
        switch ($validationObject->error) {
            case Config::getConfig('constants.responseStatus.missingInput'):
                return ApiHelpers::fail(Config::getConfig('constants.responseStatus.missingInput'), $validationObject->errorMessages->errors());
                break;
            case Config::getConfig('constants.responseStatus.operationFailed'):
                return ApiHelpers::fail(Config::getConfig('constants.responseStatus.operationFailed'), __('validation.operationFailed'));
                break;
            default:
                return ApiHelpers::success(Config::getConfig('constants.responseStatus.success'), json_encode([]));
        }
    }

}