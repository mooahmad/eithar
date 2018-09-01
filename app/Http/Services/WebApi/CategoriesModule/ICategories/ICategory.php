<?php

namespace App\Http\Services\WebApi\CategoriesModule\ICategories;


use Illuminate\Http\Request;

interface ICategory
{
    public function getMainCategories(Request $request);

    public function getChildCategories($id);

}