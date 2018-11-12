<?php

namespace App\Http\Services\WebApi\CountriesModule\ICountries;


use Illuminate\Http\Request;

interface ICountry
{
    public function getCountries(Request $request);

}