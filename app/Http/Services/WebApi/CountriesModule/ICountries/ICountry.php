<?php

namespace App\Http\Services\WebApi\CategoriesModule\ICountries;


use Illuminate\Http\Request;

interface ICountry
{
    public function getCountries(Request $request);

}