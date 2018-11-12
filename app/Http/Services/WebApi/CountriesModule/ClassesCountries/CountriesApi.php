<?php

namespace App\Http\Services\WebApi\CountriesModule\ClassesCountries;

use App\Helpers\ApiHelpers;
use App\Http\Services\WebApi\CountriesModule\AbstractCountries\Countries;
use Illuminate\Http\Request;

class CountriesApi extends Countries
{
    public function getCountries(Request $request)
    {
        $validationObject = parent::getCountries($request);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

}