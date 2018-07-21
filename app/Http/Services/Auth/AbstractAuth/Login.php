<?php

namespace App\Http\Services\Auth\AbstractAuth;

use App\Helpers\ApiHelpers;
use App\Helpers\Utilities;
use App\Http\Requests\LoginCustomer;
use App\Http\Services\Auth\IAuth\ILogin;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;


Abstract class Login implements ILogin
{
    public function loginCustomer(Request $request)
    {
        // verifies customer credentials
        $isVerified = $this->verifyCredentials($request);
        if ($isVerified !== true)
            return Utilities::getValidationError(config('constants.responseStatus.missingInput'), $isVerified->errors());
        $customer = $this->isCustomerExists($request);
        if(!$customer)
            return Utilities::getValidationError(config('constants.responseStatus.userNotFound'),
                                                 new MessageBag([
                                                                    "message" => __('errors.userNotFound')
                                                                ]));
        $customerData = clone $customer;
        $customerData = ApiHelpers::getCustomerImages($customerData);
        $customerData = ApiHelpers::getCustomerWithToken($customerData);
        $this->updateLastLoginDate($customer);
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

    private function isCustomerExists(Request $request)
    {
        $customer = Customer::where('email', $request->input('email'))->first();
        if(!$customer)
            return false;
        if(!Hash::check($request->input('password'), $customer->password))
            return false;
        return $customer;
    }

    private function updateLastLoginDate(Customer $customer){
        $customer->last_login_date = Carbon::now();
        if(!$customer->save())
            return false;
        return true;
    }
}