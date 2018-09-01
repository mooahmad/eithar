<?php

namespace App\Http\Services\WebApi\CategoriesModule\AbstractCategories;


use App\Helpers\Utilities;
use App\Http\Services\WebApi\CategoriesModule\ICategories\ICategory;
use App\Http\Services\WebApi\ServicesModule\AbstractServices\Services;
use App\Models\Category;
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

    public function getChildCategories($id)
    {
        $customerCity = Auth::user()->city_id;
        $services = Services::getCategoryServices($id);
        $categories = [];
        $providers = [];
        if ($services->isEmpty()) {
            $categories = Category::where('category_parent_id', $id)->get();
            $categories = $categories->each(function ($category) {
                $category->addHidden([
                                         'category_name_en', 'category_name_ar',
                                         'description_en', 'description_ar'
                                     ]);
            });
        } else {
            foreach ($services as $service) {
                if ($service->category && $service->category->category_parent_id == config('constants.categories.Doctor')) {
                    $providers = $service->providers()->with('cities')->whereHas('cities', function ($query) use ($customerCity) {
                        $query->where('cities.id', $customerCity);
                    })->get();
                    $providers = $providers->each(function ($provider) {
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
                    break;
                }
            }

        }
        return Utilities::getValidationError(config('constants.responseStatus.success'),
                                             new MessageBag([
                                                                "categories" => $categories,
                                                                "services"   => $services,
                                                                "providers"  => $providers
                                                            ]));
    }

}