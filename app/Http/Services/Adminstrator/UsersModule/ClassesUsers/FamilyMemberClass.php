<?php

namespace App\Http\Services\Adminstrator\UsersModule\ClassesUsers;


use App\Helpers\Utilities;
use App\Models\FamilyMember;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\MessageBag;

class FamilyMemberClass
{
    /**
     * @param FamilyMember $familyMember
     * @param $request
     * @return bool
     */
    public static function createOrUpdateFamilyMember(FamilyMember $familyMember, $request)
    {
        $familyMember->user_parent_id   = $request->input('user_parent_id');
        $familyMember->first_name       = $request->input('first_name');
        $familyMember->middle_name      = $request->input('middle_name');
        $familyMember->last_name        = $request->input('last_name');
        $familyMember->relation_type    = $request->input('relation_type');
        $familyMember->mobile_number    = $request->input('mobile_number');
        $familyMember->national_id      = $request->input('national_id');
        $familyMember->address          = $request->input('address');
        $familyMember->gender           = $request->input('gender');
        $familyMember->birthdate        = $request->input('birthdate');
        $familyMember->is_active        = $request->input('is_active');
        $familyMember->added_by         = Auth::user()->id;
        $familyMember->is_saudi_nationality = $request->input('is_saudi_nationality');
        $familyMember->save();
        return $familyMember;
    }
}