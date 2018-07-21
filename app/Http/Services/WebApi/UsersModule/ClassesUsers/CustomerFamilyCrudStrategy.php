<?php

namespace App\Http\Services\WebApi\ClassesUsers;



use Illuminate\Http\Request;

class CustomerFamilyCrudStrategy
{
    private $strategy = NULL;

    public function __construct($strategyType) {
        switch ($strategyType) {
            case config('constants.requestTypes.web'):
                $this->strategy = new CustomerFamilyCrudWeb();
                break;
            case config('constants.requestTypes.api'):
                $this->strategy = new CustomerFamilyCrudApi();
                break;
        }
    }

    public function addFamilyMember(Request $request)
    {
        return $this->strategy->addFamilyMember($request);
    }

    public function editFamilyMember(Request $request)
    {
        return $this->strategy->editFamilyMember($request);
    }

    public function getFamilyMember(Request $request)
    {
        return $this->strategy->getFamilyMember($request);
    }

    public function deleteFamilyMember(Request $request)
    {
        return $this->strategy->deleteFamilyMember($request);
    }
}