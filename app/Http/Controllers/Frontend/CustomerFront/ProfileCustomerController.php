<?php

namespace App\Http\Controllers\Frontend\CustomerFront;

use App\Http\Controllers\Controller;
use App\Http\Services\Frontend\CustomerServices\CustomerAuthServices;
use App\Models\Country;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ProfileCustomerController extends Controller
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index()
    {
        if (!auth()->guard('customer-web')->check()){
            session()->flash('error_message',trans('main.error_message'));
            return redirect()->route('customer_login');
        }
//        return auth()->guard('customer-web')->user()->notifications;

        $data = [
            'customer'=>auth()->guard('customer-web')->user(),
            'mobile'=>auth()->guard('customer-web')->user()->mobile,
            'gender'=>config('constants.gender_desc_'.LaravelLocalization::getCurrentLocale()),
            'countries'=>Country::all()->pluck('country_name_eng','id'),
            'cities'=>[],
        ];
        return view(FE.'.pages.customer.show_profile')->with($data);
    }
}
