<?php

namespace App\Http\Controllers\Frontend\CustomerFront;

use App\Helpers\Utilities;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ResetPasswordRequest;
use App\Http\Services\Adminstrator\SendingSMSModule\ClassesReport\SendingSMSClass;
use App\Mail\Customer\ForgetPasswordMail;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ResetPasswordFrontController extends Controller
{
    /**
     * ResetPasswordFrontController constructor.
     */
    public function __construct()
    {
        $this->middleware(['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showCustomerResetPassword()
    {
        return view(FE.'.pages.customer.reset_password');
    }

    /**
     * @param ResetPasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function checkCustomerResetPassword(ResetPasswordRequest $request)
    {
        $customer = (new SignUpFrontController())->checkCustomerExistByMobile(Utilities::AddCountryCodeToMobile($request->input('mobile_number')));
        if (!$customer){
            session()->flash('error_message',trans('main.invalid_mobile_number'));
            return redirect()->back()->withInput();
        }
//        TODO generate forget_password_code
        $this->generateAndUpdateForgetPasswordCode($customer);
        if ($this->sendRestPasswordCodeViaMobileEmail($customer)){
            return redirect()->route('customer_reset_password_verify_code',['mobile'=>$customer->mobile_number]);
        }

        session()->flash('error_message',trans('main.error_message'));
        return redirect()->back()->withInput();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showVerifyCustomerResetPassword(Request $request)
    {
        if (!(new SignUpFrontController())->checkCustomerExistByMobile($request->mobile)){
            session()->flash('error_message',trans('main.error_message'));
            return redirect()->route('customer_reset_password');
        }
        return view(FE.'.pages.customer.verify_reset_password_code');
    }

    /**
     * @param Customer $customer
     * @return Customer
     */
    public function generateAndUpdateForgetPasswordCode(Customer $customer)
    {
        $encryptedCode = Utilities::quickRandom(6, true);
        $customer->forget_password_code = $encryptedCode;
        $customer->save();
        return $customer;
    }

    /**
     * @param Customer $customer
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendRestPasswordCodeViaMobileEmail(Customer $customer)
    {
//        TODO Send email to customer with reset code
        Mail::to($customer->email)->send(new ForgetPasswordMail($customer));
//        TODO Send SMS to Customer To Reset Password
        $message = trans('main.send_sms_verify_code',['code'=>$customer->forget_password_code]);
        SendingSMSClass::sendSMS($message,[$customer->mobile_number]);
        return true;
    }
}
