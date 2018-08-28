<?php

namespace App\Http\Services\Adminstrator\PromoCodeModule\ClassesPromoCode;

use App\Models\PromoCode;
use Illuminate\Support\Facades\Auth;

class PromoCodeClass
{

    public static function createOrUpdate(PromoCode $promoCode, $request, $isCreate = true)
    {
        $promoCode->user_id = Auth::id();
        $promoCode->name_en = $request->input('name_en');
        $promoCode->name_ar = $request->input('name_ar');
        $promoCode->description_en = $request->input('desc_en');
        $promoCode->description_ar = $request->input('desc_ar');
        $promoCode->start_date = $request->input('start_date');
        $promoCode->end_date = $request->input('end_date');
        $promoCode->type = $request->input('type');
        $promoCode->type_description = $request->input('type_description');
        $promoCode->code_en = $request->input('code_en');
        $promoCode->code_ar = $request->input('code_ar');
        $promoCode->discount_percentage = $request->input('discount_percentage');
        $promoCode->comment = $request->input('comment');
        $promoCode->is_approved = $request->input('is_approved');
        if($isCreate)
            $promoCode->added_by = Auth::id();
        return $promoCode->save();
    }

}