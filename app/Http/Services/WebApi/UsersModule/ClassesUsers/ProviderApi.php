<?php

namespace App\Http\Services\WebApi\ClassesUsers;

use App\Helpers\ApiHelpers;
use App\Http\Services\WebApi\UsersModule\AbstractUsers\Provider;
use Illuminate\Http\Request;

class ProviderApi extends Provider
{
    public function getProvider($providerId)
    {
        $validationObject = parent::getProvider($providerId);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }
}