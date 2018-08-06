<?php

namespace App\Http\Services\WebApi\CountriesModule\ClassesCountries;

use App\Http\Services\WebApi\CountriesModule\AbstractCountries\Countries;
use Illuminate\Http\Request;

class CountriesWeb extends Countries
{
    public function getCountries(Request $request)
    {
        $data = parent::getCountries($request);
    }

}