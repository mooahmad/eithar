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
        $provider = ProviderModel::where('id', $providerId)->with(['calendar' => function ($query) use ($day) {
            if(empty($day)) {
                $day = Carbon::today()->format('Y-m-d H:m:s');
                $query->where('providers_calendars.start_date', '>=', "%$day%");
            }else{
                $day = Carbon::today()->format('Y-m-d');
                $query->where('providers_calendars.start_date', 'like', "%$day%");
            }
        }])->first();
        return Utilities::getValidationError(config('constants.responseStatus.success'),
                                             new MessageBag([
                                                                "provider" => $provider
                                                            ]));
    }
}