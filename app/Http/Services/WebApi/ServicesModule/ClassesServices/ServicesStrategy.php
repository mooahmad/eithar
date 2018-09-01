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
}