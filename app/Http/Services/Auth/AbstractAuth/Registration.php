<?php

namespace App\Http\Services\Auth\AbstractAuth;


use App\Helpers\ApiHelpers;
use App\Helpers\Utilities;
use App\Http\Requests\Auth\RegisterCustomer;
use App\Http\Services\Auth\IAuth\IRegistration;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

Abstract class Registration implements IRegistration
{
    /**
     * @param Request $request
     * @return \App\Helpers\ValidationError
     */
    public function registerCustomer(Request $request)
    {
        $customerInstance = new \App\Http\Services\WebApi\UsersModule\ClassesUsers\Customer();
        // verifies customer data
        $isVerified = $this->verifyRegisterCustomerData($request);
        if ($isVerified !== true)
            return Utilities::getValidationError(config('constants.responseStatus.missingInput'), $isVerified->errors());
        // create customer on database
        $newCustomer = $this->createCustomer(new Customer(), $request);
        if (!$newCustomer->save())
            return Utilities::getValidationError(config('constants.responseStatus.operationFailed'),
                                                 new MessageBag([
                                                                    "message" => __('errors.operationFailed')
                                                                ]));
        // uploading customer avatar
        $validationObject = $customerInstance->uploadCustomerAvatar($request, 'avatar', $newCustomer);
        if ($validationObject->error != config('constants.responseStatus.success'))
            return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                                                 new MessageBag([
                                                                    "message" => __('errors.errorUploadAvatar')
                                                                ]));
        // uploading customer national id image
        $validationObject = $customerInstance->uploadCustomerNationalIDImage($request, 'nationality_id_picture', $newCustomer);
        if ($validationObject->error != config('constants.responseStatus.success'))
            return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                                                 new MessageBag([
                                                                    "message" => __('errors.errorUploadNationalID')
                                                                ]));
        $customer = Customer::find($newCustomer->id);
        $customerData = clone $customer;
        $customerData = ApiHelpers::getCustomerImages($customerData);
        $customerData = ApiHelpers::getCustomerWithToken($customerData);
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
    private function verifyRegisterCustomerData(Request $request)
    {
        $validator = Validator::make($request->all(), (new RegisterCustomer())->rules());
        if ($validator->fails()) {
            return $validator;
        }
        return true;
    }

    /**
     * @param Customer $newCustomer
     * @param Request $request
     * @return Customer
     */
    private function createCustomer(Customer $newCustomer, Request $request)
    {
        $newCustomer->first_name = $request->input('first_name');
        $newCustomer->middle_name = $request->input('middle_name');
        $newCustomer->last_name = $request->input('last_name');
        $newCustomer->email = $request->input('email');
        $newCustomer->mobile_number = $request->input('mobile');
        $newCustomer->password = Hash::make($request->input('password'));
        $newCustomer->gender = $request->input('gender');
        $newCustomer->national_id = $request->input('national_id');
        $newCustomer->country_id = $request->input('country_id');
        $newCustomer->city_id = $request->input('city_id');
        $newCustomer->position = $request->input('position');
        $newCustomer->address = $request->input('address');
        return $newCustomer;
    }

}