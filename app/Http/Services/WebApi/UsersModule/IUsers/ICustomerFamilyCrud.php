<?php

namespace App\Http\Services\WebApi\IUsers;


use Illuminate\Http\Request;

interface ICustomerFamilyCrud
{
    public function addFamilyMember(Request $request);

    public function editFamilyMember(Request $request);

    public function getFamilyMember(Request $request);

    public function deleteFamilyMember(Request $request);

}