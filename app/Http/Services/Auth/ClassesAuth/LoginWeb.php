<?php

namespace App\Http\Services\Auth\ClassesAuth;


use App\Http\Services\Auth\AbstractAuth\Login;
use Illuminate\Http\Request;

class LoginWeb extends Login
{
    public function loginCustomer(Request $request)
    {
        $validationObject = parent::loginCustomer($request);
        return;
    }
}