<?php

namespace App\Http\Controllers\WebApi\CategoriesModule;

use App\Helpers\ApiHelpers;
use App\Http\Services\WebApi\CategoriesModule\ClassesCategories\CategoriesStrategy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getMainCategories(Request $request)
    {
        $categories = new CategoriesStrategy(ApiHelpers::requestType($request));
        return $categories->getMainCategories($request);
    }

    public function getChildCategories(Request $request, $id, $isPackage = "false")
    {
        $categories = new CategoriesStrategy(ApiHelpers::requestType($request));
        return $categories->getChildCategories($request, $id, $isPackage);
    }
}
