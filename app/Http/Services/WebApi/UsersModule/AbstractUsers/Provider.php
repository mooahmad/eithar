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
        return Utilities::getValidationError(config('constants.responseStatus.success'),
                                             new MessageBag([
                                                                "provider" => $provider
                                                            ]));
    }
}