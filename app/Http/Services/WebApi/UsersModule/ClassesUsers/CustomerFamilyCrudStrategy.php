<?php

namespace App\Http\Services\WebApi\ClassesUsers;

class CustomerFamilyCrudStrategy
{
    private $strategy = NULL;

    public function __construct($strategyType) {
        switch ($strategyType) {
            case "web":
                $this->strategy = new CustomerFamilyCrudWeb();
                break;
            case "api":
                $this->strategy = new StrategyExclaim();
                break;
        }
    }
}