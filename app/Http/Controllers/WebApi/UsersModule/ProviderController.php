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
        return $provider->getProvider($request, $providerId);
    }

    public function like(Request $request, $providerId)
    {
        $provider = new ProviderStrategy(ApiHelpers::requestType($request));
        return $provider->likeProvider($request, $providerId);
    }

    public function unlike(Request $request, $providerId)
    {
        $provider = new ProviderStrategy(ApiHelpers::requestType($request));
        return $provider->unlikeProvider($request, $providerId);
    }

    public function follow(Request $request, $providerId)
    {
        $provider = new ProviderStrategy(ApiHelpers::requestType($request));
        return $provider->followProvider($request, $providerId);
    }

    public function unFollow(Request $request, $providerId)
    {
        $provider = new ProviderStrategy(ApiHelpers::requestType($request));
        return $provider->unFollowProvider($request, $providerId);
    }

    public function rate(Request $request, $providerId)
    {
        $provider = new ProviderStrategy(ApiHelpers::requestType($request));
        return $provider->rateProvider($request, $providerId);
    }

    public function review(Request $request, $providerId)
    {
        $provider = new ProviderStrategy(ApiHelpers::requestType($request));
        return $provider->reviewProvider($request, $providerId);
    }

    public function view(Request $request, $providerId)
    {
        $provider = new ProviderStrategy(ApiHelpers::requestType($request));
        return $provider->viewProvider($request, $providerId);
    }

}
