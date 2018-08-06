<?php

namespace App\Http\Services\WebApi\CategoriesModule\ClassesCities;

use Illuminate\Http\Request;

class CitiesStrategy
{
    private $strategy = NULL;

    public function __construct($strategyType) {
        switch ($strategyType) {
            case config('constants.requestTypes.web'):
                $this->strategy = new CitiesWeb();
                break;
            case config('constants.requestTypes.api'):
                $this->strategy = new CitiesApi();
                break;
        }
    }

    public function getCities(Request $request, $countryID)
    {
        return $this->strategy->getCities($request, $countryID);
    }

}