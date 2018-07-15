<?php

namespace App\Http\Services\WebApi\ClassesUsers;

use App\Http\Services\WebApi\AbstractUsers\CustomerFamilyCrud;

class CustomerFamilyCrudApi extends CustomerFamilyCrud
{
    public function addFamilyMember()
    {
        $data = parent::addFamilyMember();
    }

    public function editFamilyMember()
    {
        $data = parent::editFamilyMember();
    }

    public function getFamilyMember()
    {
        $data = parent::getFamilyMember();
    }

    public function deleteFamilyMember()
    {
        $data = parent::deleteFamilyMember();
    }
}