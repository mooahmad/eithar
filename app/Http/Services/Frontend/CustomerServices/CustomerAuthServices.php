<?php
/**
 * Created by PhpStorm.
 * User: Ayman
 * Date: 12/10/2018
 * Time: 10:48 AM
 */

namespace App\Http\Services\Frontend\CustomerServices;

use App\Http\Controllers\Controller;
use App\Models\Customer;

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
}