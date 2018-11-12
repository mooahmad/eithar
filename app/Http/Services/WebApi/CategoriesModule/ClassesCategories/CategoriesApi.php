<?php

namespace App\Http\Services\WebApi\CategoriesModule\ClassesCategories;

use App\Helpers\ApiHelpers;
use App\Http\Services\WebApi\CategoriesModule\AbstractCategories\Categories;
use Illuminate\Http\Request;

class CategoriesApi extends Categories
{
    public function getMainCategories(Request $request)
    {
        $validationObject = parent::getMainCategories($request);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function getChildCategories(Request $request, $id, $isPackage)
    {
        $validationObject = parent::getChildCategories($request, $id, $isPackage);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

}