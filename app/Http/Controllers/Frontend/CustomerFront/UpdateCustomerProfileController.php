<?php

namespace App\Http\Controllers\Frontend\CustomerFront;

use App\Helpers\Utilities;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CustomerUpdateProfileRequest;
use App\Http\Services\Frontend\CustomerServices\CustomerAuthServices;
use App\Models\Country;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class UpdateCustomerProfileController extends Controller
{
    protected $Customer_Services;

    /**
     * UpdateCustomerProfileController constructor.
     */
    public function __construct()
    {
        $this->middleware(['CustomerWebAuth']);
        $this->Customer_Services = new CustomerAuthServices();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function showUpdateCustomerProfile(Request $request)
    {
        if (!auth()->guard('customer-web')->check()){
            session()->flash('error_message',trans('main.error_message'));
            return redirect()->route('customer_login');
        }
        $data = [
            'customer'=>auth()->guard('customer-web')->user(),
            'gender'=>config('constants.gender_desc_'.LaravelLocalization::getCurrentLocale()),
            'countries'=>Country::all()->pluck('country_name_eng','id'),
            'cities'=>[],
            'mobile'=>auth()->guard('customer-web')->user()->mobile,
        ];
        return view(FE.'.pages.customer.update_profile')->with($data);
    }

    /**
     * @param CustomerUpdateProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeUpdateCustomerProfile(CustomerUpdateProfileRequest $request)
    {
//        TODO create new customer
        $customer = $this->Customer_Services->updateORCreateCustomer(auth()->guard('customer-web')->user(),$request);
        if ($request->hasFile('profile_picture_path')){
            $customer = $this->Customer_Services->uploadCustomerImage($customer,$request,'profile_picture_path','public/images/avatars');
        }
        if ($request->hasFile('nationality_id_picture')){
            $customer = $this->Customer_Services->uploadCustomerImage($customer,$request,'nationality_id_picture','public/images/nationalities');
        }
        session()->flash('success_message',trans('main.success_message'));
        return redirect()->route('show_customer_profile',['id'=>$customer->id,'name'=>Utilities::beautyName($customer->full_name)]);
    }
}
