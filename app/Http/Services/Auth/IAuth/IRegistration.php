<?php

namespace App\Http\Services\Auth\IAuth;


use Illuminate\Http\Request;

interface IRegistration
{
    public function registerCustomer(Request $customerData);
}