<?php

namespace App\Http\Controllers\WebApi\PromoCodesModule;

use App\Helpers\ApiHelpers;
use App\Http\Services\WebApi\PromoCodesModule\ClassesPromoCodes\PromoCodesStrategy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PromoCodesController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function registerPromoCode(Request $request)
    {
        $promoCodes = new PromoCodesStrategy(ApiHelpers::requestType($request));
        return $promoCodes->registerPromoCode($request);
    }

}
