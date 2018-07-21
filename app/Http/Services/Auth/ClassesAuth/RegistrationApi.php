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
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

}