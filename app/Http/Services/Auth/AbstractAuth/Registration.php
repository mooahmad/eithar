<?php

namespace App\Http\Services\Auth\AbstractAuth;


use App\config\Config;
use App\Helpers\Utilities;
use App\Http\Services\Auth\IAuth\IRegistration;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

Abstract class Registration implements IRegistration
{
    public function registerCustomer(Request $customerData)
    {
        $isVerified = $this->verifyRegisterCustomerData($customerData);
        if ($isVerified !== true)
            return Utilities::getValidationError(Config::getConfig('constants.responseStatus.missingInput'), $isVerified);
        $newCustomer = $this->createCustomer(new Customer());
        if (!$newCustomer->save())
            return Utilities::getValidationError(Config::getConfig('constants.responseStatus.operationFailed'), []);
    }

    private function verifyRegisterCustomerData(Request $customerData)
    {
        $validator = Validator::make($customerData->all(), [
                                                         'first_name'  => 'required',
                                                         'middle_name' => 'required',
                                                         'last_name'   => 'required',
                                                         'email'       => 'required',
                                                         'mobile'      => 'required',
                                                         'password'    => 'required',
                                                         'gender'      => 'required',
                                                         'national_id' => 'required',
                                                         'country_id'  => 'required',
                                                         'city_id'     => 'required',
                                                         'position'    => 'required',
                                                         'address'     => 'required'
                                                     ]);
        if ($validator->fails()) {
            return $validator;
        }
        return true;
    }

    private function createCustomer(Customer $newCustomer, Request $customerData)
    {
        $newCustomer->first_name = $customerData->input('first_name');
        $newCustomer->middle_name = $customerData->input('middle_name');
        $newCustomer->last_name = $customerData->input('middle_name');
        $newCustomer->email = $customerData->input('email');
        $newCustomer->mobile = $customerData->input('mobile');
        $newCustomer->password = Hash::make($customerData->input('password'));
        $newCustomer->gender = $customerData->input('gender');
        $newCustomer->national_id = $customerData->input('national_id');
        $newCustomer->mobile = $customerData->input('email');
        $newCustomer->country_id = $customerData->input('country_id');
        $newCustomer->city_id = $customerData->input('city_id');
        $newCustomer->position = $customerData->input('position');
        $newCustomer->address = $customerData->input('address');
        return $newCustomer;
    }
}