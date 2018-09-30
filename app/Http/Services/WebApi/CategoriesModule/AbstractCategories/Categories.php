<?php

namespace App\Http\Services\WebApi\CategoriesModule\AbstractCategories;


use App\Helpers\ApiHelpers;
use App\Helpers\Utilities;
use App\Http\Services\WebApi\CategoriesModule\ICategories\ICategory;
use App\Http\Services\WebApi\ServicesModule\AbstractServices\Services;
use App\Http\Services\WebApi\UsersModule\AbstractUsers\Customer;
use App\LapCalendar;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Service;
use Carbon\Carbon;
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

    public function getChildCategories(Request $request, $id, $isPackage)
    {
        $customerCity = Auth::user()->city_id;
        $day = $request->input('day');
        $services = Services::getCategoryServices($request, $id, $day);
        $categories = [];
        $providers = [];
        $lapCalendar = [];
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
            $services = $services->each(function ($service) {
                $service->profile_picture_path = Utilities::getFileUrl($service->profile_picture_path);
                $service->addHidden(['benefits_en', 'benefits_ar']);
                $service->vat = 0;
                if (!Auth::user()->is_saudi_nationality)
                    $service->vat = config('constants.vat_percentage');
                $service->currency_name = Currency::find($service->currency_id)->name_eng;
                $service->total_price = $service->price + Utilities::calcPercentage($service->price, $service->vat);
            });
            if ($orderedCategory->category_parent_id == config('constants.categories.Doctor')) {
                $services->each(function ($service) use (&$serviceId, &$customerCity, &$providers, &$services) {
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
                $filteredServices = [];
                $bookedSlotsIds = (new Customer())->getBookedSlots();
                $services->each(function ($service) use (&$day, $isPackage, &$filteredServices, $id, $bookedSlotsIds) {
                    if ($isPackage == "true") {
                        if ($service->type == 2) {
                            $packageCalendar = [];
                            $availableDays = [];
                            $numberOfVisits = $service->no_of_visits;
                            $maxWeekVisits = $service->visits_per_week;
                            $currentWeekOfYear = null;
                            $numberOfDaysInCurrentWeek = 0;
                            $service->load(['calendar' => function ($query) use ($id, $service, $bookedSlotsIds) {
                                $query->where('city_id', '=', Auth::user()->city_id)
                                    ->where('start_date', '>', Carbon::now()->format('Y-m-d H:m:s'))
                                    ->where('is_available', 1);
                                if (!empty($bookedSlotsIds))
                                    $query->whereRaw("services_calendars.id NOT IN (" . implode(',', $bookedSlotsIds) . ")");
                            }]);
                            foreach ($service->calendar as $date) {
                                $currentWeek = Carbon::parse($date->start_date)->weekOfYear;
                                if ($currentWeek == $currentWeekOfYear || $currentWeekOfYear == null) {
                                    if ($maxWeekVisits > $numberOfDaysInCurrentWeek) {
                                        $day = Carbon::parse($date->start_date)->format('Y-m-d');
                                        if (!in_array($day, $availableDays)) {
                                            array_push($availableDays, $day);
                                            $currentWeekOfYear = $currentWeek;
                                            $numberOfDaysInCurrentWeek += 1;
                                        }
                                    }
                                } else {
                                    if (!in_array($day, $availableDays))
                                        array_push($availableDays, $day);
                                    $currentWeekOfYear = $currentWeek;
                                    $numberOfDaysInCurrentWeek = 0;
                                }
                            }
                            for ($i = 0; $i < $numberOfVisits; $i++) {
                                if (!isset($availableDays[$i]))
                                    break;
                                $currentCalendar = ApiHelpers::reBuildCalendar($availableDays[$i], $service->calendar);
                                array_push($packageCalendar, $currentCalendar);
                            }
                            $service->calendar_package = $packageCalendar;
                            array_push($filteredServices, $service);
                        }
                    } elseif ($isPackage == "false") {
                        if ($service->type == 1) {
                            $service->load(['calendar' => function ($query) use (&$day, $service, $bookedSlotsIds) {
                                if (empty($day)) {
                                    $date = Service::join('services_calendars', 'services.id', 'services_calendars.service_id')
                                        ->where('services.id', $service->id)
                                        ->where('services_calendars.start_date', '>', Carbon::now()->format('Y-m-d H:m:s'))
                                        ->where('services_calendars.is_available', 1)
                                        ->orderBy('services_calendars.start_date', 'asc')
                                        ->first();
                                    if (!$date)
                                        $day = Carbon::today()->format('Y-m-d');
                                    else
                                        $day = Carbon::parse($date->start_date)->format('Y-m-d');
                                    $query->where('services_calendars.city_id', '=', Auth::user()->city_id)
                                        ->where('services_calendars.start_date', 'like', "%$day%");
                                } else {
                                    $query->where('services_calendars.city_id', '=', Auth::user()->city_id)
                                        ->where('services_calendars.start_date', 'like', "%$day%");
                                }
                                if (!empty($bookedSlotsIds))
                                    $query->whereRaw("services_calendars.id NOT IN (" . implode(',', $bookedSlotsIds) . ")");
                            }]);
                            $service->calendar_dates = ApiHelpers::reBuildCalendar($day, $service->calendar);
                            array_push($filteredServices, $service);
                        }
                    }
                });
                $services = $filteredServices;
            } elseif ($orderedCategory->id == config('constants.categories.Lap')) {
                $bookedSlotsIds = (new Customer())->getBookedSlots(true);
                if (empty($day)) {
                    $date = LapCalendar::where('start_date', '>', Carbon::now()->format('Y-m-d H:m:s'))
                        ->where('is_available', 1)
                        ->where('lap_calendars.start_date', '>', Carbon::now()->format('Y-m-d H:m:s'))
                        ->orderBy('start_date', 'asc')
                        ->first();
                    if (!$date)
                        $day = Carbon::today()->format('Y-m-d');
                    else
                        $day = Carbon::parse($date->start_date)->format('Y-m-d');
                }
                $lapCalendars = LapCalendar::where('city_id', '=', Auth::user()->city_id)
                    ->where('start_date', 'like', "%$day%");
                if (!empty($bookedSlotsIds) && $bookedSlotsIds[0] != null)
                    $lapCalendars->whereRaw("lap_calendars.id NOT IN (" . implode(',', $bookedSlotsIds) . ")");
                $lapCalendars->get();
                array_push($lapCalendar, ApiHelpers::reBuildCalendar($day, $lapCalendars));
            }
        }
        return Utilities::getValidationError(config('constants.responseStatus.success'),
            new MessageBag([
                "categories" => $categories,
                "services" => $services,
                "providers" => $providers,
                "service_id" => $serviceId,
                "lap_calendar" => $lapCalendar
            ]));
    }

}