<?php

namespace App\Http\Services\WebApi\ServicesModule\ClassesServices;

use App\Helpers\ApiHelpers;
use App\Http\Services\WebApi\ServicesModule\AbstractServices\Services;
use Illuminate\Http\Request;

class ServicesApi extends Services
{
    public function getServiceQuestionnaire($id, $page = 1)
    {
        $validationObject = parent::getServiceQuestionnaire($id, $page);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function book($request, $serviceId)
    {
        $validationObject = parent::book($request, $serviceId);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

}