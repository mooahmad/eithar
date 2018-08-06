<?php

namespace App\Http\Services\WebApi\CategoriesModule\ICities;


use Illuminate\Http\Request;

interface ICity
{
    public function getCities(Request $request, $countryID);

}