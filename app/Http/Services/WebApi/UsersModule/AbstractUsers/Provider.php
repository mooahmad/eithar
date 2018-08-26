<?php

namespace App\Http\Services\WebApi\UsersModule\AbstractUsers;


use App\Helpers\Utilities;
use Carbon\Carbon;
use Illuminate\Support\MessageBag;
use App\Models\Provider as ProviderModel;

class Provider
{

    public function getProvider($request, $providerId)
    {
        $day = $request->input('day');
        if(empty($day))
            $day = Carbon::today()->format('Y-m-d');
        $provider = ProviderModel::where('id', $providerId)->with(['calendar' => function ($query) use ($day) {
            $query->where('providers_calendars.start_date', 'like', "%$day%");
        }])->first();
        $provider->addHidden([
            'title_ar', 'title_en', 'first_name_ar', 'first_name_en',
            'last_name_ar', 'last_name_en', 'speciality_area_ar', 'speciality_area_en',
            'about_ar', 'about_en', 'experience_ar', 'experience_en', 'education_ar', 'education_en'
        ]);
        return Utilities::getValidationError(config('constants.responseStatus.success'),
                                             new MessageBag([
                                                                "provider" => $provider
                                                            ]));
    }
}