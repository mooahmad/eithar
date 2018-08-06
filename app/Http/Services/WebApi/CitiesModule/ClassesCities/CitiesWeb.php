<?php

namespace App\Http\Services\WebApi\CitiesModule\ClassesCities;

use App\Http\Services\WebApi\CitiesModule\AbstractCities\Cities;
use Illuminate\Http\Request;

class CitiesWeb extends Cities
{
    public function getCities(Request $request, $countryID)
    {
        $data = parent::getCities($request, $countryID);
    }

}