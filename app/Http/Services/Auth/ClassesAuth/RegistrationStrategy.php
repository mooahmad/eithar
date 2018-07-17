<?php

namespace App\Http\Services\Auth\ClassesAuth;


use Illuminate\Http\Request;

class RegistrationStrategy
{
    private $strategy = NULL;

    // creates instance of registration class depends on strategy type and saves it to strategy variable
    public function __construct($strategyType) {
        switch ($strategyType) {
            case config('constants.requestTypes.web'):
                $this->strategy = new RegistrationWeb();
                break;
            case config('constants.requestTypes.api'):
                $this->strategy = new RegistrationApi();
                break;
        }
    }

    public function registerCustomer(Request $customerData)
    {
      return $this->strategy->registerCustomer($customerData);
    }
}