<?php

namespace App\Http\Services\WebApi\IUsers;


interface ICustomerFamilyCrud
{
    public function addFamilyMember();

    public function EditFamilyMember();

    public function getFamilyMember();

    public function deleteFamilyMember();

}