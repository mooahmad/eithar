<?php

namespace App\Http\Services\WebApi\CitiesModule\ICities;


use Illuminate\Http\Request;

interface ICity
{
    public function getCities(Request $request, $countryID);

}