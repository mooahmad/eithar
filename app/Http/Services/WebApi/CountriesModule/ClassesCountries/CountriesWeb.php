<?php

namespace App\Http\Services\WebApi\CategoriesModule\ClassesCountries;

use App\Http\Services\WebApi\CategoriesModule\AbstractCountries\Countries;
use Illuminate\Http\Request;

class CountriesWeb extends Countries
{
    public function getCountries(Request $request)
    {
        $data = parent::getCountries($request);
    }

}