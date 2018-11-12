<?php

namespace App\Http\Services\Auth\ClassesAuth;


use App\Helpers\ApiHelpers;
use App\Http\Services\Auth\AbstractAuth\Login;
use Illuminate\Http\Request;

class LoginWeb extends Login
{
    public function loginCustomer(Request $request)
    {
        $validationObject = parent::loginCustomer($request);
        return $validationObject;
    }

    public function loginProvider(Request $request)
    {
        $providerInstance = new \App\Http\Services\WebApi\UsersModule\AbstractUsers\Provider();
        $provider = $providerInstance->isProviderExists($request);
        if ($provider){
            $providerInstance->updateLastLoginDate($provider);
            $providerData = ApiHelpers::getProviderWithToken($provider);
        }
        return $providerData;
    }
}