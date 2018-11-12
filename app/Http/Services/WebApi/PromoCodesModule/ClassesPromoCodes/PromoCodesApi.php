<?php

namespace App\Http\Services\WebApi\PromoCodesModule\ClassesPromoCodes;

use App\Helpers\ApiHelpers;
use App\Http\Services\WebApi\PromoCodesModule\AbstractPromoCodes\PromoCodes;
use Illuminate\Http\Request;

class PromoCodesApi extends PromoCodes
{
    public function registerPromoCode(Request $request)
    {
        $validationObject = parent::registerPromoCode($request);
        if ($validationObject->error == config('constants.responseStatus.success'))
            return ApiHelpers::success($validationObject->error, $validationObject->errorMessages);
        return ApiHelpers::fail($validationObject->error, $validationObject->errorMessages);
    }

}