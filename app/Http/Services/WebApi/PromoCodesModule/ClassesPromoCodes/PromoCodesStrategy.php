<?php

namespace App\Http\Services\WebApi\PromoCodesModule\ClassesPromoCodes;

use Illuminate\Http\Request;

class PromoCodesStrategy
{
    private $strategy = NULL;

    public function __construct($strategyType) {
        switch ($strategyType) {
            case config('constants.requestTypes.web'):
                $this->strategy = new PromoCodesWeb();
                break;
            case config('constants.requestTypes.api'):
                $this->strategy = new PromoCodesApi();
                break;
        }
    }

    public function registerPromoCode(Request $request)
    {
        return $this->strategy->registerPromoCode($request);
    }

}