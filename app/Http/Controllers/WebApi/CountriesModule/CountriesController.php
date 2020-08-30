<?php

namespace App\Http\Controllers\WebApi\CountriesModule;

use App\Helpers\ApiHelpers;
use App\Http\Services\WebApi\CountriesModule\ClassesCountries\CountriesStrategy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountriesController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getCountries(Request $request)
    {
        $countries = new CountriesStrategy(ApiHelpers::requestType($request));
        return $countries->getCountries($request);
    }

}
