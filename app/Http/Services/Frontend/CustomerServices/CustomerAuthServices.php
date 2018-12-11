<?php
/**
 * Created by PhpStorm.
 * User: Ayman
 * Date: 12/10/2018
 * Time: 10:48 AM
 */

namespace App\Http\Services\Frontend\CustomerServices;

use App\Helpers\Utilities;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CustomerAuthServices extends Controller
{
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
     * @param $id
     * @return null
     */
    public function checkCustomerExistByID($id)
    {
        $customer = Customer::findOrFail($id);
        if (!$customer) return null;
        return $customer;
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
}