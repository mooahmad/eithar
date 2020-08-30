<?php

namespace App\Http\Services\WebApi\PromoCodesModule\IPromoCodes;


use Illuminate\Http\Request;

interface IPromoCode
{
    public function registerPromoCode(Request $request);

}