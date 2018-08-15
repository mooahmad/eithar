<?php

namespace App\Http\Services\WebApi\ClassesUsers;

use Illuminate\Http\Request;

class ProviderStrategy
{
    private $strategy = NULL;

    public function __construct($strategyType) {
        switch ($strategyType) {
            case config('constants.requestTypes.web'):
                $this->strategy = new ProviderWeb();
                break;
            case config('constants.requestTypes.api'):
                $this->strategy = new ProviderApi();
                break;
        }
    }

    public function getProvider($request, $providerId)
    {
        return $this->strategy->getProvider($request, $providerId);
    }

}