<?php

namespace App\Http\Services\Adminstrator\UsersModule\ClassesUsers;


use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomersClass
{
    /**
     * @param Customer $customer
     * @param $request
     * @return Customer
     */
    public static function createOrUpdateCustomer(Customer $customer, $request)
    {
        $customer->country_id       = $request->input('country_id');
        $customer->city_id          = $request->input('city_id');
        $customer->first_name       = $request->input('first_name');
        $customer->middle_name      = $request->input('middle_name');
        $customer->last_name        = $request->input('last_name');
        $customer->email            = $request->input('email');
        $customer->mobile_number    = $request->input('mobile_number');
        $customer->password         = Hash::make($request->input('password'));
        $customer->national_id      = $request->input('national_id');
        $customer->address          = $request->input('address');
        $customer->gender           = $request->input('gender');
        $customer->birthdate        = $request->input('birthdate');
        $customer->about            = $request->input('about');
        $customer->is_active        = $request->input('is_active');
        $customer->added_by         = Auth::user()->id;
        $customer->is_saudi_nationality = $request->input('is_saudi_nationality');
        $customer->save();
        return $customer;
    }
}