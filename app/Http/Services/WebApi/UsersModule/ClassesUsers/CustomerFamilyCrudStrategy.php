<?php

namespace App\Http\Services\WebApi\ClassesUsers;

use App\config\Config;

class CustomerFamilyCrudStrategy
{
    private $strategy = NULL;

    public function __construct($strategyType) {
        switch ($strategyType) {
            case Config::getConfig('constants.requestTypes.web'):
                $this->strategy = new CustomerFamilyCrudWeb();
                break;
            case Config::getConfig('constants.requestTypes.api'):
                $this->strategy = new CustomerFamilyCrudApi();
                break;
        }
    }

    public function addFamilyMember()
    {
        return $this->strategy->addFamilyMember();
    }

    public function editFamilyMember()
    {
        return $this->strategy->editFamilyMember();
    }

    public function getFamilyMember()
    {
        return $this->strategy->getFamilyMember();
    }

    public function deleteFamilyMember()
    {
        return $this->strategy->deleteFamilyMember();
    }
}