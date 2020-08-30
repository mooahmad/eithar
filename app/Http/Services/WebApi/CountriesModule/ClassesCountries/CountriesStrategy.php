<?php

namespace App\Http\Services\WebApi\CountriesModule\ClassesCountries;

use Illuminate\Http\Request;

class CountriesStrategy
{
    private $strategy = NULL;

    public function __construct($strategyType) {
        switch ($strategyType) {
            case config('constants.requestTypes.web'):
                $this->strategy = new CountriesWeb();
                break;
            case config('constants.requestTypes.api'):
                $this->strategy = new CountriesApi();
                break;
        }
    }

    public function getCountries(Request $request)
    {
        return $this->strategy->getCountries($request);
    }

}