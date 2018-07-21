<?php

namespace App\Http\Services\WebApi\ClassesUsers;

use App\Http\Services\WebApi\UsersModule\ClassesUsers\Customer;
use Illuminate\Http\Request;
use App\Models\Customer as CustomerModel;

class CustomerWeb extends Customer
{
    public function uploadCustomerAvatar(Request $request, $fileName, CustomerModel $customer)
    {
        return parent::uploadCustomerAvatar($request, $fileName, $customer);
    }

    public function uploadCustomerNationalIDImage(Request $request, $fileName, CustomerModel $customer)
    {
        return parent::uploadCustomerNationalIDImage($request, $fileName, $customer);
    }
}