<?php

namespace App\Http\Services\Auth\ClassesAuth;


use App\config\Config;
use Illuminate\Support\Facades\Request;

class RegistrationStrategy
{
    private $strategy = NULL;

    public function __construct($strategyType) {
        switch ($strategyType) {
            case Config::getConfig('constants.requestTypes.web'):
                $this->strategy = new RegistrationWeb();
                break;
            case Config::getConfig('constants.requestTypes.api'):
                $this->strategy = new RegistrationApi();
                break;
        }
    }

    public function registerCustomer(Request $customerData)
    {
      return $this->strategy->registerCustomer($customerData);
    }
}