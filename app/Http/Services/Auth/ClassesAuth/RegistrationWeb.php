<?php

namespace App\Http\Services\Auth\ClassesAuth;


use App\Http\Services\Auth\AbstractAuth\Registration;
use Illuminate\Http\Request;

class RegistrationWeb extends Registration
{
    public function registerCustomer(Request $customerData)
    {
         $data = parent::registerCustomer($customerData);
    }

}