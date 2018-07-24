<?php

namespace App\Http\Services\WebApi\AbstractUsers;


use App\Helpers\Utilities;
use App\Http\Requests\CustomerFamily\AddFamilyMember;
use App\Http\Requests\CustomerFamily\EditFamilyMember;
use App\Http\Requests\CustomerFamily\GetFamilyMember;
use App\Http\Services\WebApi\IUsers\ICustomerFamilyCrud;
use App\Models\FamilyMember;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

abstract class CustomerFamilyCrud implements ICustomerFamilyCrud
{

    public function addFamilyMember(Request $request)
    {
        $isVerified = $this->verifyMemberData($request);
        if ($isVerified !== true)
            return Utilities::getValidationError(config('constants.responseStatus.missingInput'), $isVerified->errors());
        $newMember = $this->createOrUpdateFamilyMember(new FamilyMember(), $request);
        if (!$newMember->save())
            return Utilities::getValidationError(config('constants.responseStatus.operationFailed'),
                                                 new MessageBag([
                                                                    "message" => __('errors.operationFailed')
                                                                ]));
        $newMember->save();
        $validationObject = $this->uploadMemberImage($request, 'member_picture', $newMember);
        if ($validationObject->error != config('constants.responseStatus.success'))
            return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                                                 new MessageBag([
                                                                    "message" => __('errors.errorUploadMember')
                                                                ]));
        $newMember->profile_picture_path = Utilities::getFileUrl($newMember->profile_picture_path);
        $newMember = Utilities::forgetModelItems($newMember, [
            'nationality_id',
            'birthdate',
            'deleted_at'
        ]);
        return Utilities::getValidationError(config('constants.responseStatus.success'),
                                             new MessageBag([
                                                                "member" => $newMember
                                                            ]));

    }

    private function verifyMemberData(Request $request)
    {
        $validator = Validator::make($request->all(), (new AddFamilyMember())->rules());
        if ($validator->fails()) {
            return $validator;
        }
        return true;
    }

    private function createOrUpdateFamilyMember(FamilyMember $member, Request $request, $isCreate = true)
    {
        $member->user_parent_id = Auth::user()->id;
        $member->first_name = $request->input('first_name');
        $member->middle_name = $request->input('middle_name');
        $member->last_name = $request->input('last_name');
        $member->relation_type = $request->input('relation_type');
        $member->mobile_number = $request->input('mobile');
        $member->national_id = $request->input('national_id');
        $member->address = $request->input('address');
        if($isCreate)
        $member->created_at = Carbon::now()->toDateTimeString();
        $member->updated_at = Carbon::now()->toDateTimeString();
        return $member;
    }

    private function uploadMemberImage(Request $request, $fileName, FamilyMember $member)
    {
        if ($request->hasFile($fileName)) {
            $isValidImage = Utilities::validateImage($request, $fileName);
            if (!$isValidImage)
                return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                                                     new MessageBag([
                                                                        "message" => __('errors.errorUploadMember')
                                                                    ]));
            $isUploaded = Utilities::UploadImage($request->file($fileName), 'public/images/familymembers');
            if (!$isUploaded)
                return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                                                     new MessageBag([
                                                                        "message" => __('errors.errorUploadMember')
                                                                    ]));
            Utilities::DeleteImage($member->profile_picture_path);
            $member->profile_picture_path = $isUploaded;
            if (!$member->save())
                return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                                                     new MessageBag([
                                                                        "message" => __('errors.errorUploadMember')
                                                                    ]));
            return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));
        }
        return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));
    }

    public function editFamilyMember(Request $request)
    {
        $isVerified = $this->verifyEditMemberData($request);
        if ($isVerified !== true)
            return Utilities::getValidationError(config('constants.responseStatus.missingInput'), $isVerified->errors());
        $member = FamilyMember::find($request->input('member_id'));
        $member = $this->createOrUpdateFamilyMember($member, $request, false);
        if (!$member->save())
            return Utilities::getValidationError(config('constants.responseStatus.operationFailed'),
                                                 new MessageBag([
                                                                    "message" => __('errors.operationFailed')
                                                                ]));
        $validationObject = $this->uploadMemberImage($request, 'member_picture', $member);
        if ($validationObject->error != config('constants.responseStatus.success'))
            return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                                                 new MessageBag([
                                                                    "message" => __('errors.errorUploadMember')
                                                                ]));
        $member->profile_picture_path = Utilities::getFileUrl($member->profile_picture_path);
        $member = Utilities::forgetModelItems($member, [
            'nationality_id',
            'birthdate',
            'deleted_at'
        ]);
        return Utilities::getValidationError(config('constants.responseStatus.success'),
                                             new MessageBag([
                                                                "member" => $member
                                                            ]));
    }

    private function verifyEditMemberData(Request $request)
    {
        $validator = Validator::make($request->all(), (new EditFamilyMember())->rules());
        if ($validator->fails()) {
            return $validator;
        }
        return true;
    }

    public function getFamilyMember(Request $request)
    {
        $isVerified = $this->verifyGetMemberData($request);
        if ($isVerified !== true)
            return Utilities::getValidationError(config('constants.responseStatus.missingInput'), $isVerified->errors());
        $member = FamilyMember::find($request->input('member_id'));
        $member->profile_picture_path = Utilities::getFileUrl($member->profile_picture_path);
        $member = Utilities::forgetModelItems($member, [
            'nationality_id',
            'birthdate',
            'deleted_at'
        ]);
        return Utilities::getValidationError(config('constants.responseStatus.success'),
                                             new MessageBag([
                                                                "member" => $member
                                                            ]));
    }

    private function verifyGetMemberData(Request $request)
    {
        $validator = Validator::make($request->all(), (new GetFamilyMember())->rules());
        if ($validator->fails()) {
            return $validator;
        }
        return true;
    }

    public function deleteFamilyMember(Request $request)
    {
        $isVerified = $this->verifyGetMemberData($request);
        if ($isVerified !== true)
            return Utilities::getValidationError(config('constants.responseStatus.missingInput'), $isVerified->errors());
        $member = FamilyMember::find($request->input('member_id'));
        if (!$member->delete())
            return Utilities::getValidationError(config('constants.responseStatus.operationFailed'),
                                                 new MessageBag([
                                                                    "message" => __('errors.operationFailed')
                                                                ]));
        return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));
    }

    public function getFamilyMembers(Request $request)
    {
        $members = FamilyMember::where('user_parent_id', Auth::user()->id)->get();
        for ($i = 0; $i < count($members); $i++) {
            $members[$i]->profile_picture_path = Utilities::getFileUrl($members[$i]->profile_picture_path);
            $members[$i] = Utilities::forgetModelItems($members[$i], [
                'nationality_id',
                'birthdate',
                'deleted_at'
            ]);
        }
        return Utilities::getValidationError(config('constants.responseStatus.success'),
                                             new MessageBag([
                                                                "members" => $members
                                                            ]));
    }
}