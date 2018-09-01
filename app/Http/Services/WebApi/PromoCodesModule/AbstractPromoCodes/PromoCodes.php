<?php

namespace App\Http\Services\WebApi\PromoCodesModule\AbstractPromoCodes;


use App\Helpers\Utilities;
use App\Http\Services\WebApi\PromoCodesModule\IPromoCodes\IPromoCode;
use App\Models\PromoCode;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

abstract class PromoCodes implements IPromoCode
{

    public function registerPromoCode(Request $request)
    {
        $promoCode = $request->input('promocode');
        $serviceId = $request->input('serviceid');
        $total_price = $request->input('total_price');
        $now = Carbon::now()->format('Y-m-d H:m:s');
        $promoCode = PromoCode::where([['code', "$promoCode"], ['is_approved', 1]])
            ->where([['start_date', '<=', $now], ['end_date', '>', $now]])
            ->first();
        if (!$promoCode)
            return Utilities::getValidationError(config('constants.responseStatus.operationFailed'),
                new MessageBag([
                    "message" => "code not found"
                ]));
        $service = Service::find($serviceId);
        if (!$service)
            return Utilities::getValidationError(config('constants.responseStatus.operationFailed'),
                new MessageBag([
                    "message" => "service not found"
                ]));
        if ($promoCode->type == 0 || $service->type == $promoCode->type)
            return Utilities::getValidationError(config('constants.responseStatus.success'),
                new MessageBag([
                    "total_price" => $total_price - Utilities::calcPercentage($total_price, $promoCode->discount_percentage)
                ]));
        return Utilities::getValidationError(config('constants.responseStatus.operationFailed'),
            new MessageBag([
                "message" => "promo code is not valid for this service"
            ]));
    }

}