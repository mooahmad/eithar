<?php

namespace App\Http\Services\WebApi\CategoriesModule\AbstractCategories;


use App\Helpers\Utilities;
use App\Http\Services\WebApi\CategoriesModule\ICategories\ICategory;
use App\Http\Services\WebApi\ServicesModule\AbstractServices\Services;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function getChildCategories($id, $isPackage)
    {
        $customerCity = Auth::user()->city_id;
        $services = Services::getCategoryServices($id);
        $categories = [];
        $providers = [];
        $serviceId = null;
        if ($services->isEmpty()) {
            $categories = Category::where('category_parent_id', $id)->get();
            $categories = $categories->each(function ($category) {
                $category->addHidden([
                    'category_name_en', 'category_name_ar',
                    'description_en', 'description_ar'
                ]);
            });
        } else {
            $orderedCategory = Category::find($id);
            if ($orderedCategory->category_parent_id == config('constants.categories.Doctor')) {
                $services->each(function ($service) use (&$serviceId, &$customerCity, &$providers, &$services, $isPackage) {
                    $serviceId = $service->id;
                    $providers = $service->providers()->with('cities')->whereHas('cities', function ($query) use ($customerCity) {
                        $query->where('cities.id', $customerCity);
                    })->get();
                    $providers = $providers->each(function ($provider) use ($service) {
                        $provider->addHidden([
                            'title_ar', 'title_en', 'first_name_ar', 'first_name_en',
                            'last_name_ar', 'last_name_en', 'speciality_area_ar', 'speciality_area_en',
                            'about_ar', 'about_en', 'experience_ar', 'experience_en', 'education_ar', 'education_en', 'pivot'
                        ]);
                        $provider->cities = $provider->cities->each(function ($city) {
                            $city->addHidden([
                                'city_name_ara', 'city_name_eng'
                            ]);
                        });
                    });
                    $services = [];
                });
            } elseif ($orderedCategory->category_parent_id == config('constants.categories.Physiotherapy') || $orderedCategory->category_parent_id == config('constants.categories.Nursing') || $orderedCategory->category_parent_id == config('constants.categories.WomanAndChild')) {
                $services = $services->reject(function ($service) use ($isPackage) {
                    if ($isPackage) {
                        if ($service->type == 2)
                            return false;
                        else
                            return true;
                    } elseif (!$isPackage) {
                        if ($service->type == 1)
                            return false;
                        else
                            return true;
                    }
                });
            }
        }
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([
                "categories" => $categories,
                "services" => $services,
                "providers" => $providers,
                "service_id" => $serviceId
            ]));
    }

}