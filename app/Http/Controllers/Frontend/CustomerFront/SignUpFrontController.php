<?php

namespace App\Http\Controllers\Frontend\CustomerFront;

use App\Helpers\Utilities;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CheckMobileCodeVerifyRequest;
use App\Http\Requests\Frontend\CheckMobileNumberRequest;
use App\Http\Requests\Frontend\CustomerSignUpRequest;
use App\Http\Services\Adminstrator\SendingSMSModule\ClassesReport\SendingSMSClass;
use App\Mail\Auth\VerifyEmailCode;
use App\Models\City;
use App\Models\Country;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SignUpFrontController extends Controller
{
    protected $customer_ip_info;

    /**
     * SignUpFrontController constructor.
     */
    public function __construct()
    {
        $this->middleware(['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']);
        $this->customer_ip_info = Utilities::GetCustomerInfoByIp();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showCustomerSignUp()
    {
        if (auth()->guard('customer-web')->check()) return redirect()->route('home');
        $position ='';
        if ($this->customer_ip_info['latitude'] && $this->customer_ip_info['longitude']){
            $position = $this->customer_ip_info['latitude'].','.$this->customer_ip_info['longitude'];
        }
        $data = [
            'gender'=>config('constants.gender_desc_'.LaravelLocalization::getCurrentLocale()),
            'countries'=>Country::all()->pluck('country_name_eng','id'),
            'cities'=>[],
            'position'=>$position,
        ];
        return view(FE.'.pages.customer.sign_up')->with($data);
    }

    /**
     * @param CustomerSignUpRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function saveCustomerSignUp(CustomerSignUpRequest $request)
    {
//        TODO create new customer
        $customer = $this->updateORCreateCustomer(new Customer(),$request);
        $customer = $this->uploadCustomerImage($customer,$request,'profile_picture_path','public/images/avatars');
        $customer = $this->uploadCustomerImage($customer,$request,'nationality_id_picture','public/images/nationalities');

//        TODO Send SMS and Email to customer with verify code To Active Account
        $this->sendVerifyCodeToCustomerViaMobileEmail($customer);
        return redirect()->route('verify_sent_code',['mobile'=>$customer->mobile_number]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCountryCities(Request $request)
    {
        if ($request->ajax()){
            if ($request->has('country_id')){
                $cities = City::where('country_id',$request->get('country_id'))
                    ->get();
                $html='';
                if (!empty($cities)){
                    foreach ($cities as $city) {
                        $selected = '';
                        if (auth()->guard('customer-web')->check() && auth()->guard('customer-web')->user()->city_id == $city->id){
                            $selected = 'selected';
                        }
                        $html .= '<option value="'.$city->id.'" '.$selected.'>'.$city->name.'</option>';
                    }
                }
                return response()->json(
                    [
                        'result'=>true,
                        'list'=>$html
                    ]
                );
            }
            return response()->json(
                [
                    'result'=>false,
                    'list'=>[]
                ]
            );
        }
    }

    /**
     * @param Customer $customer
     * @param Request $request
     * @param bool $isCreate
     * @return Customer
     */
    public function updateORCreateCustomer(Customer $customer, Request $request, $isCreate = true)
    {
        $customer->first_name           = $request->input('first_name');
        $customer->middle_name          = $request->input('middle_name');
        $customer->last_name            = $request->input('last_name');
        $customer->email                = $request->input('email');
        $customer->mobile_number        = Utilities::AddCountryCodeToMobile($request->input('mobile_number'));
        $customer->password             = bcrypt($request->input('password'));
        $customer->gender               = $request->input('gender');
        $customer->national_id          = $request->input('national_id');
        $customer->country_id           = $request->input('country_id');
        $customer->city_id              = $request->input('city_id');
        $customer->position             = $request->input('position');
        $customer->address              = $request->input('address');
        $customer->about                = $request->input('about');
        $customer->default_language     = LaravelLocalization::getCurrentLocale();
        $customer->save();
        if ($isCreate) {
            $code = Utilities::quickRandom(4, true);
            $customer->email_code       = $code;
            $customer->mobile_code      = $code;
            $customer->eithar_id        = config('constants.CustomerEitharID').$customer->id;
        }
        $customer->save();
        return $customer->refresh();
    }

    /**
     * @param $customer
     * @param Request $request
     * @param $image_name
     * @param $image_path
     * @return mixed
     */
    public function uploadCustomerImage($customer,Request $request,$image_name,$image_path)
    {
        if ($request->hasFile($image_name)){
            $avatar = Utilities::UploadFile($request->file($image_name),$image_path);
            if ($avatar){
                $customer->{$image_name} = $avatar;
                $customer->save();
            }
        }
        return $customer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showCustomerVerifyMobileCode(Request $request)
    {
        $customer = $this->checkCustomerExistByMobile($request->mobile);

        if (!$customer) return redirect()->route('customer_login');

        return view(FE.'.pages.customer.verify_sent_code')->with(['mobile'=>$customer->mobile_number]);
    }

    /**
     * @param CheckMobileCodeVerifyRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activeCustomerVerifyMobileCode(CheckMobileCodeVerifyRequest $request)
    {
//        TODO check mobile_code for this customer
        $customer = $this->checkCustomerSentVerifyCode($request->input('mobile_number'),$request->input('mobile_code'));
        if (!$customer){
            session()->flash('error_message',trans('main.invalid_code'));
            return redirect()->back()->withInput();
        }

//        TODO activate customer account
        $this->activateCustomerAccount($customer);

//        TODO login and update last login date
        Auth::guard('customer-web')->login($customer,true);
        (new LoginFrontController())->updateCustomerLastLogin();
        session()->flash('account_activate',trans('main.account_activate'));
        return redirect()->route('home');
    }

    /**
     * @param $mobile_number
     * @param $code
     * @return null
     */
    public function checkCustomerSentVerifyCode($mobile_number,$code)
    {
        $customer = Customer::where('mobile_number',$mobile_number)->where('mobile_code',$code)->first();
        if (!$customer) return null;
        return $customer;
    }

    /**
     * @param Customer $customer
     */
    public function activateCustomerAccount(Customer $customer)
    {
        $customer->is_active       = 1;
        $customer->email_verified  = 1;
        $customer->mobile_verified = 1;
        $customer->save();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function resendCustomerVerifyCode()
    {
        return view(FE.'.pages.customer.resend_verify_code');
    }

    /**
     * @param CheckMobileNumberRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function resendCustomerVerifyCodePost(CheckMobileNumberRequest $request)
    {
//        TODO check if customer exist by mobile
        $customer = $this->checkCustomerExistByMobile($request->input('mobile_number'));

        if (!$customer){
            session()->flash('error_message',trans('main.invalid_mobile_number'));
            return redirect()->back()->withInput();
        }

        if ($this->sendVerifyCodeToCustomerViaMobileEmail($customer)){
            session()->flash('code_sent_successfully',trans('main.code_sent_successfully'));
            return redirect()->route('verify_sent_code',['mobile'=>$customer->mobile_number]);
        }
        session()->flash('error_message',trans('main.error_message'));
        return redirect()->back();
    }

    /**
     * @param $mobile
     * @return null
     */
    public function checkCustomerExistByMobile($mobile)
    {
        $customer = Customer::where('mobile_number',$mobile)->first();
        if (!$customer) return null;
        return $customer;
    }

    /**
     * @param Customer $customer
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendVerifyCodeToCustomerViaMobileEmail(Customer $customer)
    {
//        TODO Send email to customer with verify code
        Mail::to($customer->email)->send(new VerifyEmailCode($customer));

//        TODO Send SMS to Customer To Active Account
        $message = trans('main.send_sms_verify_code',['code'=>$customer->mobile_code]);
        SendingSMSClass::sendSMS($message,[$customer->mobile_number]);
        return true;
    }
}
