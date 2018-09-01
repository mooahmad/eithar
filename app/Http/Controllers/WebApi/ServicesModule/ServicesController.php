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

    public function book(Request $request, $serviceId)
    {
        $services = new ServicesStrategy(ApiHelpers::requestType($request));
        return $services->book($request, $serviceId);
    }
}
