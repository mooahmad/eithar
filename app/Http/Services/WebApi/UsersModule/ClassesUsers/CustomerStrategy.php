<?php

namespace App\Http\Services\WebApi\ClassesUsers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerStrategy
{
    private $strategy = NULL;

    public function __construct($strategyType) {
        switch ($strategyType) {
            case config('constants.requestTypes.web'):
                $this->strategy = new CustomerWeb();
                break;
            case config('constants.requestTypes.api'):
                $this->strategy = new CustomerApi();
                break;
        }
    }

    public function uploadCustomerAvatar(Request $request, $fileName, Customer $customer)
    {
        return $this->strategy->uploadCustomerAvatar($request, $fileName, $customer);
    }

    public function uploadCustomerNationalIDImage(Request $request, $fileName, Customer $customer)
    {
        return $this->strategy->uploadCustomerNationalIDImage($request, $fileName, $customer);
    }

    public function updateLastLoginDate(Customer $customer)
    {
        return $this->strategy->updateLastLoginDate($customer);
    }

    public function isCustomerExists(Request $request)
    {
        return $this->strategy->isCustomerExists($request);
    }
}