<?php

namespace App\Http\Services\WebApi\CategoriesModule\ClassesCategories;

use Illuminate\Http\Request;

class CategoriesStrategy
{
    private $strategy = NULL;

    public function __construct($strategyType) {
        switch ($strategyType) {
            case config('constants.requestTypes.web'):
                $this->strategy = new CategoriesWeb();
                break;
            case config('constants.requestTypes.api'):
                $this->strategy = new CategoriesApi();
                break;
        }
    }

    public function getMainCategories(Request $request)
    {
        return $this->strategy->getMainCategories($request);
    }

    public function getChildCategories(Request $request, $id, $isPackage)
    {
        return $this->strategy->getChildCategories($request, $id, $isPackage);
    }
}