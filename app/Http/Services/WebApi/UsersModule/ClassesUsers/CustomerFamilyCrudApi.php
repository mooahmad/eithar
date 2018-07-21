<?php

namespace App\Http\Services\WebApi\ClassesUsers;

use App\Helpers\ApiHelpers;
use App\Http\Services\WebApi\AbstractUsers\CustomerFamilyCrud;
use Illuminate\Http\Request;

class CustomerFamilyCrudApi extends CustomerFamilyCrud
{
    public function addFamilyMember(Request $request)
    {
        $validationObject = parent::addFamilyMember($request);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function editFamilyMember(Request $request)
    {
        $validationObject = parent::editFamilyMember($request);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function getFamilyMember(Request $request)
    {
        $validationObject = parent::getFamilyMember($request);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

    public function deleteFamilyMember(Request $request)
    {
        $validationObject = parent::deleteFamilyMember($request);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }
}