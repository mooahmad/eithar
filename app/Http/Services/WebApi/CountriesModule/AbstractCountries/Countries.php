<?php

namespace App\Http\Services\WebApi\CategoriesModule\AbstractCountries;


use App\Helpers\Utilities;
use App\Http\Services\WebApi\CategoriesModule\ICountries\ICountry;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

abstract class Countries implements ICountry
{

    public function getCountries(Request $request)
    {
        $countries = Country::all();
        return Utilities::getValidationError(config('constants.responseStatus.success'),
                                             new MessageBag([
                                                                "countries" => $countries
                                                            ]));
    }
}