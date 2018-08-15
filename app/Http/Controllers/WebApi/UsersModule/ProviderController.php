<?php

namespace App\Http\Controllers\WebApi\UsersModule;

use App\Helpers\ApiHelpers;
use App\Http\Services\WebApi\ClassesUsers\ProviderStrategy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProviderController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getProvider(Request $request, $providerId)
    {
        $provider = new ProviderStrategy(ApiHelpers::requestType($request));
        return $provider->getProvider($providerId);
    }

}
