<?php

namespace App\Http\Services\Auth\AbstractAuth;


use App\Helpers\ApiHelpers;
use App\Helpers\Utilities;
use App\Http\Requests\RegisterCustomer;
use App\Http\Services\Auth\IAuth\IRegistration;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

Abstract class Registration implements IRegistration
{
    /**
     * @param Request $customerData
     * @return \App\Helpers\ValidationError
     */
    public function registerCustomer(Request $customerData)
    {
        // verifies customer data
        $isVerified = $this->verifyRegisterCustomerData($customerData);
        if ($isVerified !== true)
            return Utilities::getValidationError(config('constants.responseStatus.missingInput'), $isVerified->errors());
        // create customer on database
        $newCustomer = $this->createCustomer(new Customer(), $customerData);
        if (!$newCustomer->save())
            return Utilities::getValidationError(config('constants.responseStatus.operationFailed'),
                                                 new MessageBag([
                                                                    "message" => __('errors.operationFailed')
                                                                ]));
        // uploading customer avatar
        $isUploaded = $this->uploadCustomerAvatar($customerData, 'avatar', $newCustomer);
        if (!$isUploaded)
            return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                                                 new MessageBag([
                                                                    "message" => __('errors.errorUploadAvatar')
                                                                ]));
        // uploading customer national id image
            $isUploaded = $this->uploadCustomerNationalIDImage($customerData,'nationality_id_picture', $newCustomer);
            if (!$isUploaded)
                return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                                                     new MessageBag([
                                                                        "message" => __('errors.errorUploadNationalID')
                                                                    ]));
        $customer = Customer::find($newCustomer->id);
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
     * @param Request $customerData
     * @return bool|\Illuminate\Contracts\Validation\Validator
     */
    private function verifyRegisterCustomerData(Request $customerData)
    {
        $validator = Validator::make($customerData->all(), (new RegisterCustomer())->rules());
        if ($validator->fails()) {
            return $validator;
        }
        return true;
    }

    /**
     * @param Customer $newCustomer
     * @param Request $customerData
     * @return Customer
     */
    private function createCustomer(Customer $newCustomer, Request $customerData)
    {
        $newCustomer->first_name = $customerData->input('first_name');
        $newCustomer->middle_name = $customerData->input('middle_name');
        $newCustomer->last_name = $customerData->input('last_name');
        $newCustomer->email = $customerData->input('email');
        $newCustomer->mobile_number = $customerData->input('mobile');
        $newCustomer->password = Hash::make($customerData->input('password'));
        $newCustomer->gender = $customerData->input('gender');
        $newCustomer->national_id = $customerData->input('national_id');
        $newCustomer->country_id = $customerData->input('country_id');
        $newCustomer->city_id = $customerData->input('city_id');
        $newCustomer->position = $customerData->input('position');
        $newCustomer->address = $customerData->input('address');
        return $newCustomer;
    }

    /**
     * @param $customerAvatar
     * @param Customer $customer
     * @return bool
     */
    private function uploadCustomerAvatar(Request $request, $fileName, Customer $customer)
    {
        if ($request->hasFile($fileName)) {
            $isValidImage = Utilities::validateImage($request, $fileName);
            if (!$isValidImage)
                return false;
            $isUploaded = Utilities::UploadImage($request->file($fileName), 'public/images/avatars');
            if (!$isUploaded)
                return false;
            $customer->profile_picture_path = $isUploaded;
            if (!$customer->save())
                return false;
            return true;
        }
        return true;
    }

    /**
     * @param $nationalIDImage
     * @param Customer $customer
     * @return bool
     */
    private function uploadCustomerNationalIDImage(Request $request, $fileName, Customer $customer)
    {
        if ($request->hasFile($fileName)) {
            $isValidImage = Utilities::validateImage($request, $fileName);
            if (!$isValidImage)
                return false;
            $isUploaded = Utilities::UploadImage($request->file($fileName), 'public/images/nationalities');
            if (!$isUploaded)
                return false;
            $customer->nationality_id_picture = $isUploaded;
            if (!$customer->save())
                return false;
            return true;
        }
        return true;
    }

    private function updateLastLoginDate(Customer $customer){
        $customer->last_login_date = Carbon::now();
        if(!$customer->save())
            return false;
        return true;
    }
}