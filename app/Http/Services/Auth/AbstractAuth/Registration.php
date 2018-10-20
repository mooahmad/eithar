<?php

namespace App\Http\Services\Auth\AbstractAuth;


use App\Helpers\ApiHelpers;
use App\Helpers\Utilities;
use App\Http\Services\Auth\IAuth\IRegistration;
use App\Mail\Auth\VerifyEmailCode;
use App\Models\Customer;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\MessageBag;

class Registration implements IRegistration
{
    /**
     * @param Request $request
     * @return \App\Helpers\ValidationError
     */
    public function registerCustomer(Request $request)
    {
        $customerInstance = new \App\Http\Services\WebApi\UsersModule\AbstractUsers\Customer();
        // verifies customer data
        $isVerified = $customerInstance->verifyRegisterCustomerData($request);
        if ($isVerified !== true)
            return Utilities::getValidationError(config('constants.responseStatus.missingInput'), $isVerified->errors());
        // create customer on database
        $newCustomer = new Customer();
        if (Auth::check())
            $newCustomer = Customer::find(Auth::user()->id);
        $newCustomer = $customerInstance->updateORCreateCustomer($newCustomer, $request);
        if (!$newCustomer->save())
            return Utilities::getValidationError(config('constants.responseStatus.operationFailed'),
                new MessageBag([
                    "message" => trans('errors.operationFailed')
                ]));
        $newCustomer->eithar_id = "Etr-0000{$newCustomer->id}";
        $newCustomer->save();
        $customerOperations = new \App\Http\Services\WebApi\UsersModule\AbstractUsers\Customer();
        $customerOperations->updateCustomerToken($newCustomer, $request);
        // uploading customer avatar
        $validationObject = $customerInstance->uploadCustomerAvatar($request, 'avatar', $newCustomer);
        if ($validationObject->error != config('constants.responseStatus.success'))
            return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                new MessageBag([
                    "message" => trans('errors.errorUploadAvatar')
                ]));
        // uploading customer national id image
        $validationObject = $customerInstance->uploadCustomerNationalIDImage($request, 'nationality_id_picture', $newCustomer);
        if ($validationObject->error != config('constants.responseStatus.success'))
            return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                new MessageBag([
                    "message" => trans('errors.errorUploadNationalID')
                ]));
        $settings = Settings::find(1);
        $customer = Customer::find($newCustomer->id);
        $customerData = clone $customer;
        $customerData = ApiHelpers::getCustomerImages($customerData);
        $customerData->company_number = $settings->mobile_number;
        $customerData->company_whats_app_number = $settings->whats_app_number;
        $customerData->company_customer_banner = Utilities::getFileUrl($settings->customer_banner_path);
        $customerData->notifications_count = $customer->unreadnotifications->count();
        if (!Auth::check())
            $customerData = ApiHelpers::getCustomerWithToken($customerData);
        Utilities::forgetModelItems($customerData, [
            'registration_source',
            'registration_source_desc',
            'birthdate'
        ]);
        $customerInstance->updateLastLoginDate($customer);
        if (!Auth::check())
            Mail::to($customer->email)->send(new VerifyEmailCode($customer));
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([
                "user" => $customerData
            ]));
    }

}