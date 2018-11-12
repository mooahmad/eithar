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

    public function getServiceCalendar(Request $request, $serviceId)
    {
        $validationObject = parent::getServiceCalendar($request, $serviceId);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function getLapCalendar(Request $request)
    {
        $validationObject = parent::getLapCalendar($request);
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

    public function cancelBook($request, $appointmentId)
    {
        $validationObject = parent::cancelBook($request, $appointmentId);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function likeService($request, $serviceId)
    {
        $validationObject = parent::likeService($request, $serviceId);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function unlikeService($request, $serviceId)
    {
        $validationObject = parent::unlikeService($request, $serviceId);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function followService($request, $serviceId)
    {
        $validationObject = parent::followService($request, $serviceId);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function unFollowService($request, $serviceId)
    {
        $validationObject = parent::unFollowService($request, $serviceId);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function rateService($request, $serviceId)
    {
        $validationObject = parent::rateService($request, $serviceId);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function reviewService($request, $serviceId)
    {
        $validationObject = parent::reviewService($request, $serviceId);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function viewService($request, $serviceId)
    {
        $validationObject = parent::viewService($request, $serviceId);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function getService($request, $serviceId)
    {
        $validationObject = parent::getService($request, $serviceId);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    /**
     * @param $request
     * @return \App\Helpers\ValidationError|string
     */
    public function changeItemStatus($request)
    {
        $validationObject = parent::changeItemStatus($request);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

}