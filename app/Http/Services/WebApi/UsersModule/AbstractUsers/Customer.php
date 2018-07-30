<?php

namespace App\Http\Services\WebApi\UsersModule\AbstractUsers;


use App\Helpers\Utilities;
use App\Http\Requests\Auth\RegisterCustomer;
use App\Http\Requests\Auth\UpdateForgetPasswordRequest;
use App\Http\Requests\Auth\VerifyCustomerEmail;
use App\Http\Services\Auth\AbstractAuth\Registration;
use App\Mail\Auth\VerifyEmailCode;
use App\Mail\Customer\ForgetPasswordMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Customer as CustomerModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Auth\LoginCustomer;

class Customer
{
    /**
     * @param $customerAvatar
     * @param Customer $customer
     * @return bool
     */
    public function uploadCustomerAvatar(Request $request, $fileName, CustomerModel $customer)
    {
        if ($request->hasFile($fileName)) {
            $isValidImage = Utilities::validateImage($request, $fileName);
            if (!$isValidImage)
                return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                                                     new MessageBag([
                                                                        "message" => __('errors.errorUploadAvatar')
                                                                    ]));
            $isUploaded = Utilities::UploadImage($request->file($fileName), 'public/images/avatars');
            if (!$isUploaded)
                return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                                                     new MessageBag([
                                                                        "message" => __('errors.errorUploadAvatar')
                                                                    ]));
            Utilities::DeleteImage($customer->profile_picture_path);
            $customer->profile_picture_path = $isUploaded;
            if (!$customer->save())
                return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                                                     new MessageBag([
                                                                        "message" => __('errors.errorUploadAvatar')
                                                                    ]));
            return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));
        }
        return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));
    }

    /**
     * @param $nationalIDImage
     * @param Customer $customer
     * @return bool
     */
    public function uploadCustomerNationalIDImage(Request $request, $fileName, CustomerModel $customer)
    {
        if ($request->hasFile($fileName)) {
            $isValidImage = Utilities::validateImage($request, $fileName);
            if (!$isValidImage)
                return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                                                     new MessageBag([
                                                                        "message" => __('errors.errorUploadNationalID')
                                                                    ]));
            $isUploaded = Utilities::UploadImage($request->file($fileName), 'public/images/nationalities');
            if (!$isUploaded)
                return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                                                     new MessageBag([
                                                                        "message" => __('errors.errorUploadNationalID')
                                                                    ]));
            Utilities::DeleteImage($customer->nationality_id_picture);
            $customer->nationality_id_picture = $isUploaded;
            if (!$customer->save())
                return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                                                     new MessageBag([
                                                                        "message" => __('errors.errorUploadNationalID')
                                                                    ]));
            return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));
        }
        return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));
    }

    /**
     * verifies customer data using validator with rules
     * @param Request $request
     * @return bool|\Illuminate\Contracts\Validation\Validator
     */
    public function verifyRegisterCustomerData(Request $request)
    {
        $customerID = null;
        if (Auth::check())
            $customerID = Auth::user()->id;
        $validator = Validator::make($request->all(), (new RegisterCustomer())->rules($customerID));
        if ($validator->fails()) {
            return $validator;
        }
        return true;
    }

    /**
     * verifies customer data using validator with rules
     * @param Request $request
     * @return bool|\Illuminate\Contracts\Validation\Validator
     */
    public function verifyCustomerCredentials(Request $request)
    {
        $validator = Validator::make($request->all(), (new LoginCustomer())->rules());
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
    public function updateORCreateCustomer(CustomerModel $customer, Request $request, $isCreate = true)
    {
        $customer->first_name = $request->input('first_name');
        $customer->middle_name = $request->input('middle_name');
        $customer->last_name = $request->input('last_name');
        $customer->email = $request->input('email');
        $customer->mobile_number = $request->input('mobile');
        $customer->password = Hash::make($request->input('password'));
        $customer->gender = $request->input('gender');
        $customer->national_id = $request->input('national_id');
        $customer->country_id = $request->input('country_id');
        $customer->city_id = $request->input('city_id');
        $customer->position = $request->input('position');
        $customer->address = $request->input('address');
        if ($isCreate) {
            $customer->email_code = Utilities::quickRandom(4, true);
            $customer->mobile_code = Utilities::quickRandom(4, true);
        }
        return $customer;
    }

    public function editCustomer(Request $request)
    {
        return (new Registration())->registerCustomer($request);

    }

    /**
     * @param CustomerModel $customer
     * @return bool
     */
    public function updateLastLoginDate(CustomerModel $customer)
    {
        $customer->last_login_date = Carbon::now();
        if (!$customer->save())
            return false;
        return true;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function isCustomerExists(Request $request)
    {
        $customer = CustomerModel::where('mobile_number', $request->input('mobile'))->first();
        if (!$customer)
            return false;
        if (!Hash::check($request->input('password'), $customer->password))
            return false;
        return $customer;
    }

    public function verifyCustomerEmail(Request $request)
    {
        $isVerified = $this->validateVerifyCustomerEmail($request);
        if ($isVerified !== true)
            return Utilities::getValidationError(config('constants.responseStatus.missingInput'), $isVerified->errors());
        $customer = CustomerModel::where([['email', $request->input('email')], ['email_code', $request->input('email_code')]])->first();
        if (!$customer)
            return Utilities::getValidationError(config('constants.responseStatus.operationFailed'),
                                                 new MessageBag([
                                                                    "message" => __('errors.wrongCode')
                                                                ]));
        $customer->email_verified = 1;
        $customer->save();
        return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));
    }

    private function validateVerifyCustomerEmail(Request $request)
    {
        $validator = Validator::make($request->all(), (new VerifyCustomerEmail())->rules());
        if ($validator->fails()) {
            return $validator;
        }
        return true;
    }

    public function resendEmailVerificationCode(Request $request)
    {
        Mail::to(Auth::user()->email)->send(new VerifyEmailCode(CustomerModel::find(Auth::user()->id)));
        return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));
    }

    public function forgetPassword(Request $request)
    {
        $isVerified = $this->validateForgetPassword($request);
        if ($isVerified !== true)
            return Utilities::getValidationError(config('constants.responseStatus.missingInput'), $isVerified->errors());
        $customer = CustomerModel::where('mobile_number', $request->input('mobile'))->first();
        if (!$customer)
            return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));
        $encrytedCode = Utilities::quickRandom(6, true);
        $customer->forget_password_code = $encrytedCode;
        $customer->save();
        Mail::to($customer->email)->send(new ForgetPasswordMail($customer));
        return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));

    }

    private function validateForgetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
        ]);
        if ($validator->fails()) {
            return $validator;
        }
        return true;
    }

    public function updateForgottenPassword(Request $request)
    {
        $isVerified = $this->validateUpdateForgetPassword($request);
        if ($isVerified !== true)
            return Utilities::getValidationError(config('constants.responseStatus.missingInput'), $isVerified->errors());
        $customer = CustomerModel::where([['mobile_number', $request->input('mobile')], ['forget_password_code', $request->input('code')]])->first();
        if (!$customer)
            return Utilities::getValidationError(config('constants.responseStatus.userNotFound'),
                                                 new MessageBag([
                                                                    'message' => __('errors.userNotFound')
                                                                ]));
        $customer->password  = Hash::make($request->input('password'));
        $customer->save();
        return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));

    }

    private function validateUpdateForgetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), (new UpdateForgetPasswordRequest())->rules());
        if ($validator->fails()) {
            return $validator;
        }
        return true;
    }


}