<?php

namespace App\Http\Services\WebApi\CountriesModule\AbstractCountries;


use App\Helpers\Utilities;
use App\Http\Services\WebApi\CountriesModule\ICountries\ICountry;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

abstract class Countries implements ICountry
{

    public function getCountries(Request $request)
    {
        $countries = Country::all();
        foreach ($countries as $country)
            Utilities::forgetModelItems($country, ["country_name_eng", "country_name_ara"]);
        return Utilities::getValidationError(config('constants.responseStatus.success'),
                                             new MessageBag([
                                                                "countries" => $countries
                                                            ]));
    }
}