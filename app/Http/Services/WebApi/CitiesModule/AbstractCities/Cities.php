<?php

namespace App\Http\Services\WebApi\CategoriesModule\AbstractCities;


use App\Helpers\Utilities;
use App\Http\Services\WebApi\CategoriesModule\ICities\ICity;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

abstract class Cities implements ICity
{

    public function getCities(Request $request, $countryID)
    {
        $cities = City::where('country_id', $countryID)->get();
        return Utilities::getValidationError(config('constants.responseStatus.success'),
                                             new MessageBag([
                                                                "cities" => $cities
                                                            ]));
    }
}