<?php

namespace App\Http\Services\WebApi\CategoriesModule\ClassesCategories;

use App\Http\Services\WebApi\CategoriesModule\AbstractCategories\Categories;
use Illuminate\Http\Request;

class CategoriesWeb extends Categories
{
    public function getMainCategories(Request $request)
    {
        $data = parent::getMainCategories($request);
    }

    public function getChildCategories($id)
    {
        $data = parent::getChildCategories($id);
    }
}