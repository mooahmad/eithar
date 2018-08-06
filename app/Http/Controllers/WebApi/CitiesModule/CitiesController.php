<?php

namespace App\Http\Controllers\WebApi\CitiesModule;

use App\Helpers\ApiHelpers;
use App\Http\Services\WebApi\CategoriesModule\ClassesCities\CitiesStrategy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CitiesController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getCities(Request $request, $countryID)
    {
        $categories = new CitiesStrategy(ApiHelpers::requestType($request));
        return $categories->getCities($request, $countryID);
    }

}
