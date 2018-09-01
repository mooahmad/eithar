<?php

namespace App\Http\Services\WebApi\UsersModule\AbstractUsers;


use App\Helpers\Utilities;
use App\Http\Services\WebApi\CommonTraits\Follows;
use App\Http\Services\WebApi\CommonTraits\Likes;
use App\Http\Services\WebApi\CommonTraits\Ratings;
use App\Http\Services\WebApi\CommonTraits\Reviews;
use App\Http\Services\WebApi\CommonTraits\Views;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use App\Models\Provider as ProviderModel;

class Provider
{
    use Likes, Follows, Ratings, Views, Reviews;

    public function getProvider($request, $providerId)
    {
        $day = $request->input('day');
        $provider = ProviderModel::where('id', $providerId)->with(['calendar' => function ($query) use ($day) {
            if(empty($day)) {
                $day = Carbon::today()->format('Y-m-d H:m:s');
                $query->where('providers_calendars.start_date', '>=', "%$day%");
            }else{
                $query->where('providers_calendars.start_date', 'like', "%$day%");
            }
        }])->first();
        $provider->addHidden([
            'title_ar', 'title_en', 'first_name_ar', 'first_name_en',
            'last_name_ar', 'last_name_en', 'speciality_area_ar', 'speciality_area_en',
            'about_ar', 'about_en', 'experience_ar', 'experience_en', 'education_ar', 'education_en'
        ]);
        $provider->cities = $provider->cities->each(function ($city) {
            $city->addHidden([
                'city_name_ara', 'city_name_eng'
            ]);
        });
        $provider->vat = 0;
        if(!Auth::user()->is_saudi_nationality)
            $provider->vat = config('constants.vat_percentage');
        $provider->total_price = $provider->price + Utilities::calcPercentage($provider->price, $provider->vat);

        return Utilities::getValidationError(config('constants.responseStatus.success'),
                                             new MessageBag([
                                                                "provider" => $provider
                                                            ]));
    }
}