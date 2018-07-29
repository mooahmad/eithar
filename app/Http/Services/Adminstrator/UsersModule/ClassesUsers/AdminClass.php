<?php

namespace App\Http\Services\Adminstrator\UsersModule\ClassesUsers;


use App\User;
use Illuminate\Http\Request;

class AdminClass
{

    public static function createOrUpdateAdmin(User $user, $request){
        $user->first_name = $request->input('first_name');
        $user->middle_name = $request->input('middle_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->mobile_number = $request->input('mobile');
        $user->password = Hash::make($request->input('password'));
        $user->user_type = $request->input('user_type');
        $user->gender = $request->input('gender');
        $user->default_language = $request->input('default_language');
        $user->birthdate = $request->input('birthdate');
        $user->national_id = $request->input('national_id');
        $user->nationality_id = $request->input('nationality_id');
        $user->is_saudi_nationality = $request->input('is_saudi_nationality');
        $user->about = $request->input('about');
        return $user->save();
    }
}