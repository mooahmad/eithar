<?php

namespace App\Http\Services\WebApi\PromoCodesModule\ClassesPromoCodes;

use App\Http\Services\WebApi\PromoCodesModule\AbstractPromoCodes\PromoCodes;
use Illuminate\Http\Request;

class PromoCodesWeb extends PromoCodes
{
    public function registerPromoCode(Request $request)
    {
        $data = parent::registerPromoCode($request);
    }

}