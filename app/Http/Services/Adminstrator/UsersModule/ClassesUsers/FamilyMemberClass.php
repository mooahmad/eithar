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
        $familyMember->is_saudi_nationality = $request->input('is_saudi_nationality');
        $familyMember->added_by         = Auth::user()->id;
        $familyMember->save();
        return $familyMember;
    }

    /**
     * @param Request $request
     * @param $fileName
     * @param $path
     * @param User $user
     * @return mixed
     */
    public static function uploadAdminImage(Request $request, $fileName, $path, User $user, $fieldName)
    {
        if ($request->hasFile($fileName)) {
            $isValidImage = Utilities::validateImage($request, $fileName);
            if (!$isValidImage)
                return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                                                     new MessageBag([
                                                                        "message" => trans('errors.errorUploadAvatar')
                                                                    ]));
            $isUploaded = Utilities::uploadFile($request->file($fileName), $path);
            if (!$isUploaded)
                return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                                                     new MessageBag([
                                                                        "message" => trans('errors.errorUploadAvatar')
                                                                    ]));
            Utilities::DeleteFile($user->{$fieldName});
            $user->{$fieldName} = $isUploaded;
            if (!$user->save())
                return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                                                     new MessageBag([
                                                                        "message" => trans('errors.errorUploadAvatar')
                                                                    ]));
            return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));
        }
        return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));
    }

}