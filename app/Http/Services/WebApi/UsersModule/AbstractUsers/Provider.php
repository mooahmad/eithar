<?php

namespace App\Http\Services\WebApi\UsersModule\AbstractUsers;


use App\Helpers\Utilities;
use Illuminate\Support\MessageBag;
use App\Models\Provider as ProviderModel;

class Provider
{

    public function getProvider($providerId)
    {
        $provider = ProviderModel::find($providerId);
        return Utilities::getValidationError(config('constants.responseStatus.success'),
                                             new MessageBag([
                                                                "provider" => $provider
                                                            ]));
    }
}