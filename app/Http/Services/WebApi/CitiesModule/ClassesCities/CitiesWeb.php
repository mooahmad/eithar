<?php

namespace App\Http\Services\WebApi\CategoriesModule\ClassesCities;

use App\Http\Services\WebApi\CategoriesModule\AbstractCities\Cities;
use Illuminate\Http\Request;

class CitiesWeb extends Cities
{
    public function getCities(Request $request, $countryID)
    {
        $data = parent::getCities($request, $countryID);
    }

}