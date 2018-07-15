<?php

namespace App\Http\Services\WebApi\IUsers;


interface ICustomerFamilyCrud
{
    public function addFamilyMember();

    public function editFamilyMember();

    public function getFamilyMember();

    public function deleteFamilyMember();

}