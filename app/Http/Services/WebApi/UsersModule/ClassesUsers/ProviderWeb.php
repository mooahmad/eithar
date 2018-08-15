<?php

namespace App\Http\Services\WebApi\ClassesUsers;

use App\Http\Services\WebApi\UsersModule\AbstractUsers\Provider;

class ProviderWeb extends Provider
{
    public function getProvider($request, $providerId)
    {
        return parent::getProvider($request, $providerId);
    }

}