<?php

namespace App\Http\Services\Adminstrator\UsersModule\ClassesUsers;


use App\Helpers\Utilities;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\MessageBag;

class AdminClass
{

    public static function createOrUpdateAdmin(User $user, $request, $isCreate = true)
    {
        $user->first_name = $request->input('first_name');
        $user->middle_name = $request->input('middle_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->mobile_number = $request->input('mobile');
        if ($isCreate || (!$isCreate && !empty($request->input('password'))))
            $user->password = Hash::make($request->input('password'));
        $user->user_type = $request->input('user_type');
        $user->gender = $request->input('gender');
        $user->default_language = $request->input('default_language');
        $user->birthdate = Carbon::parse($request->input('birthdate'))->format('Y-m-d H:m:s');
        $user->national_id = $request->input('national_id');
        $user->nationality_id = $request->input('nationality_id');
        $user->is_saudi_nationality = $request->input('is_saudi_nationality');
        if($request->has('is_active'))
        $user->is_active = $request->input('is_active');
        $user->about = $request->input('about');
        if ($isCreate) {
            $user->added_by = Auth::user()->id;
            $user->email_code = Utilities::quickRandom(4, true);
            $user->mobile_code = Utilities::quickRandom(4, true);
        }
        return $user->save();
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
            $isUploaded = Utilities::UploadImage($request->file($fileName), $path);
            if (!$isUploaded)
                return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                                                     new MessageBag([
                                                                        "message" => trans('errors.errorUploadAvatar')
                                                                    ]));
            Utilities::DeleteImage($user->{$fieldName});
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