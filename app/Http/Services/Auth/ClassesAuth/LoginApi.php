<?php

namespace App\Http\Services\Auth\ClassesAuth;


use App\Helpers\ApiHelpers;
use App\Http\Services\Auth\AbstractAuth\Login;
use Illuminate\Http\Request;

class LoginApi extends Login
{
    public function loginCustomer(Request $request)
    {
        $validationObject = parent::loginCustomer($request);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }
}