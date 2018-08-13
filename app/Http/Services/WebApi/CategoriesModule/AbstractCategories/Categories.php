<?php

namespace App\Http\Services\WebApi\CategoriesModule\AbstractCategories;


use App\Helpers\Utilities;
use App\Http\Services\WebApi\CategoriesModule\ICategories\ICategory;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

abstract class Categories implements ICategory
{

    public function getMainCategories(Request $request)
    {
        $categories = Category::all()->take(5);
        $categories = $categories->each(function ($category) {
            $category->addHidden([
                                     'category_name_en', 'category_name_ar',
                                     'description_en', 'description_ar'
                                 ]);
        });
        return Utilities::getValidationError(config('constants.responseStatus.success'),
                                             new MessageBag([
                                                                "categories" => $categories
                                                            ]));
    }

    public function getChildCategories($id)
    {
        $services = Service::where('category_id', $id)->get();
        $services = $services->each(function ($service) {
            $service->addHidden([
                                    'name_en', 'name_ar',
                                    'desc_en', 'desc_ar'
                                ]);
        });
        $categories = [];
        if (!$services) {
            $categories = Category::where('category_parent_id', $id)->get();
            $categories = $categories->each(function ($category) {
                $category->addHidden([
                                         'category_name_en', 'category_name_ar',
                                         'description_en', 'description_ar'
                                     ]);
            });
        }
        return Utilities::getValidationError(config('constants.responseStatus.success'),
                                             new MessageBag([
                                                                "categories" => $categories,
                                                                "services"   => $services
                                                            ]));
    }
}