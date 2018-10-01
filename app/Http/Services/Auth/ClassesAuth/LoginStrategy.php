<?php

namespace App\Http\Services\Auth\ClassesAuth;


use Illuminate\Http\Request;

class LoginStrategy
{
    private $strategy = NULL;

    // creates instance of registration class depends on strategy type and saves it to strategy variable
    public function __construct($strategyType)
    {
        switch ($strategyType) {
            case config('constants.requestTypes.web'):
                $this->strategy = new LoginWeb();
                break;
            case config('constants.requestTypes.api'):
                $this->strategy = new LoginApi();
                break;
        }
    }

    public function loginCustomer(Request $request)
    {
        return $this->strategy->loginCustomer($request);
    }

    public function loginProvider(Request $request)
    {
        return $this->strategy->loginProvider($request);
    }
}