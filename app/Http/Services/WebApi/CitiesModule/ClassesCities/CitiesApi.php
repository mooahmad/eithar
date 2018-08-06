<?php

namespace App\Http\Services\WebApi\CategoriesModule\ClassesCities;

use App\Helpers\ApiHelpers;
use App\Http\Services\WebApi\CategoriesModule\AbstractCities\Cities;
use Illuminate\Http\Request;

class CitiesApi extends Cities
{
    public function getCities(Request $request, $countryID)
    {
        $validationObject = parent::getCities($request, $countryID);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

}