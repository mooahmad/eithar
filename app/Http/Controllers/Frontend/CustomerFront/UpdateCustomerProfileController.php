<?php

namespace App\Http\Controllers\Frontend\CustomerFront;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class UpdateCustomerProfileController extends Controller
{
    /**
     * UpdateCustomerProfileController constructor.
     */
    public function __construct()
    {
        $this->middleware(['CustomerWebAuth']);
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
//        dd(auth()->guard('customer-web')->user()->mobile);
        $data = [
            'customer'=>auth()->guard('customer-web')->user(),
            'gender'=>config('constants.gender_desc_'.LaravelLocalization::getCurrentLocale()),
            'countries'=>Country::all()->pluck('country_name_eng','id'),
            'cities'=>[],
            'mobile'=>auth()->guard('customer-web')->user()->mobile,
        ];
        return view(FE.'.pages.customer.update_profile')->with($data);
    }

    public function storeUpdateCustomerProfile(Request $request)
    {
        return $request->all();
    }
}
