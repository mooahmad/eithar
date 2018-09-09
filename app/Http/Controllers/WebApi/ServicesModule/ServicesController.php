<?php

namespace App\Http\Controllers\WebApi\ServicesModule;

use App\Helpers\ApiHelpers;
use App\Http\Services\WebApi\ServicesModule\ClassesServices\ServicesStrategy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServicesController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getServiceQuestionnaire(Request $request, $id, $page = 1)
    {
        $services = new ServicesStrategy(ApiHelpers::requestType($request));
        return $services->getServiceQuestionnaire($id, $page);
    }

    public function getLapCalendar(Request $request)
    {
        $services = new ServicesStrategy(ApiHelpers::requestType($request));
        return $services->getLapCalendar($request);
    }

    public function book(Request $request, $serviceId)
    {
        $services = new ServicesStrategy(ApiHelpers::requestType($request));
        return $services->book($request, $serviceId);
    }

    public function like(Request $request, $serviceId)
    {
        $service = new ServicesStrategy(ApiHelpers::requestType($request));
        return $service->likeService($request, $serviceId);
    }

    public function unlike(Request $request, $serviceId)
    {
        $service = new ServicesStrategy(ApiHelpers::requestType($request));
        return $service->unlikeService($request, $serviceId);
    }

    public function follow(Request $request, $serviceId)
    {
        $service = new ServicesStrategy(ApiHelpers::requestType($request));
        return $service->followService($request, $serviceId);
    }

    public function unFollow(Request $request, $serviceId)
    {
        $service = new ServicesStrategy(ApiHelpers::requestType($request));
        return $service->unFollowService($request, $serviceId);
    }

    public function rate(Request $request, $serviceId)
    {
        $service = new ServicesStrategy(ApiHelpers::requestType($request));
        return $service->rateService($request, $serviceId);
    }

    public function review(Request $request, $serviceId)
    {
        $service = new ServicesStrategy(ApiHelpers::requestType($request));
        return $service->reviewService($request, $serviceId);
    }

    public function view(Request $request, $serviceId)
    {
        $service = new ServicesStrategy(ApiHelpers::requestType($request));
        return $service->viewService($request, $serviceId);
    }
}
