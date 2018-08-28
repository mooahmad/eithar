<?php

namespace App\Http\Services\WebApi\CategoriesModule\AbstractCategories;


use App\Helpers\Utilities;
use App\Http\Services\WebApi\CategoriesModule\ICategories\ICategory;
use App\Models\Category;
use App\Models\Provider;
use App\Models\Questionnaire;
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

    public function getChildCategories($id)
    {
        $customerCity = Auth::user()->city_id;
        $services = Service::where('category_id', $id)->get();
        $services = $services->each(function ($service) {
            $service->addHidden([
                                    'name_en', 'name_ar',
                                    'desc_en', 'desc_ar'
                                ]);
        });
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
                    $providers = $service->providers()->whereHas('cities', function ($query) use ($customerCity) {
                        $query->where('cities.id', $customerCity);
                    })->get();
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

    public function getServiceQuestionnaire($id, $page = 1)
    {
        $pagesCount = Questionnaire::where('service_id', $id)->max('pagination');
        $questionnaire = Questionnaire::where([['service_id', $id], ['pagination', $page]])->get();
        $questionnaire->each(function ($questionnaire) {
            $questionnaire->options_ar = unserialize($questionnaire->options_ar);
            $questionnaire->options_en = unserialize($questionnaire->options_en);
            $questionnaire->addHidden([
                'title_ar', 'title_en', 'subtitle_ar', 'subtitle_en'
            ]);
    });
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([
                "questionnaire" => $questionnaire,
                "pagesCount" => $pagesCount,
                "currentPage" => $page
            ]));
    }
}