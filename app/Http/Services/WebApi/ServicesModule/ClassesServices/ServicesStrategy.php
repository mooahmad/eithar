<?php

namespace App\Http\Services\WebApi\ServicesModule\ClassesServices;

use Illuminate\Http\Request;

class ServicesStrategy
{
    private $strategy = NULL;

    public function __construct($strategyType) {
        switch ($strategyType) {
            case config('constants.requestTypes.web'):
                $this->strategy = new ServicesWeb();
                break;
            case config('constants.requestTypes.api'):
                $this->strategy = new ServicesApi();
                break;
        }
    }

    public function getServiceQuestionnaire($id, $page = 1)
    {
        return $this->strategy->getServiceQuestionnaire($id, $page);
    }

    public function getServiceCalendar($request, $serviceId)
    {
        return $this->strategy->getServiceCalendar($request, $serviceId);
    }

    public function getLapCalendar($request)
    {
        return $this->strategy->getLapCalendar($request);
    }

    public function book($request, $serviceId)
    {
        return $this->strategy->book($request, $serviceId);
    }

    public function cancelBook($request, $appointmentId)
    {
        return $this->strategy->cancelBook($request, $appointmentId);
    }

    public function likeService($request, $serviceId)
    {
        return $this->strategy->likeService($request, $serviceId);
    }

    public function unlikeService($request, $serviceId)
    {
        return $this->strategy->unlikeService($request, $serviceId);
    }

    public function followService($request, $serviceId)
    {
        return $this->strategy->followService($request, $serviceId);
    }

    public function unFollowService($request, $serviceId)
    {
        return $this->strategy->unFollowService($request, $serviceId);
    }

    public function rateService($request, $serviceId)
    {
        return $this->strategy->rateService($request, $serviceId);
    }

    public function reviewService($request, $serviceId)
    {
        return $this->strategy->reviewService($request, $serviceId);
    }

    public function viewService($request, $serviceId)
    {
        return $this->strategy->viewService($request, $serviceId);
    }

    public function getService($request, $serviceId)
    {
        return $this->strategy->getService($request, $serviceId);
    }
}