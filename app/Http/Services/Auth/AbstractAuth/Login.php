<?php

namespace App\Http\Services\Auth\AbstractAuth;

use App\Helpers\ApiHelpers;
use App\Helpers\Utilities;
use App\Http\Requests\Auth\LoginCustomer;
use App\Http\Services\Auth\IAuth\ILogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;


Abstract class Login implements ILogin
{

    public function loginCustomer(Request $request)
    {
        $customerInstance = new \App\Http\Services\WebApi\UsersModule\ClassesUsers\Customer();
        // verifies customer credentials
        $isVerified = $this->verifyCredentials($request);
        if ($isVerified !== true)
            return Utilities::getValidationError(config('constants.responseStatus.missingInput'), $isVerified->errors());
        $customer = $customerInstance->isCustomerExists($request);
        if (!$customer)
            return Utilities::getValidationError(config('constants.responseStatus.userNotFound'),
                                                 new MessageBag([
                                                                    "message" => __('errors.userNotFound')
                                                                ]));
        $customerData = clone $customer;
        $customerData = ApiHelpers::getCustomerImages($customerData);
        $customerData = ApiHelpers::getCustomerWithToken($customerData);
        $customerData = Utilities::forgetModelItems($customerData, [
            'registration_source',
            'registration_source_desc',
            'birthdate'
        ]);
        $customerInstance->updateLastLoginDate($customer);
        return Utilities::getValidationError(config('constants.responseStatus.success'),
                                             new MessageBag([
                                                                "user" => $customerData
                                                            ]));
    }

    /**
     * verifies customer data using validator with rules
     * @param Request $request
     * @return bool|\Illuminate\Contracts\Validation\Validator
     */
    private function verifyCredentials(Request $request)
    {
        $validator = Validator::make($request->all(), (new LoginCustomer())->rules());
        if ($validator->fails()) {
            return $validator;
        }
        return true;
    }

}