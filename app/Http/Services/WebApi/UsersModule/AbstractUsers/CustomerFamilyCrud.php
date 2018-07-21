<?php

namespace App\Http\Services\WebApi\AbstractUsers;


use App\Helpers\Utilities;
use App\Http\Requests\CustomerFamily\AddFamilyMember;
use App\Http\Services\WebApi\IUsers\ICustomerFamilyCrud;
use App\Models\FamilyMember;
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
        $newMember = $this->createFamilyMember(new FamilyMember(), $request);
        if (!$newMember->save())
            return Utilities::getValidationError(config('constants.responseStatus.operationFailed'),
                                                 new MessageBag([
                                                                    "message" => __('errors.operationFailed')
                                                                ]));
        $validationObject = $this->uploadMemberImage($request, 'member_picture', $newMember);
        if ($validationObject->error != config('constants.responseStatus.success'))
            return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                                                 new MessageBag([
                                                                    "message" => __('errors.errorUploadMember')
                                                                ]));
        return Utilities::getValidationError(config('constants.responseStatus.success'),
                                             new MessageBag([
                                                                "member" => $newMember
                                                            ]));

    }

    public function editFamilyMember(Request $request)
    {

    }

    public function getFamilyMember(Request $request)
    {

    }

    public function deleteFamilyMember(Request $request)
    {

    }

    private function verifyMemberData(Request $request)
    {
        $validator = Validator::make($request->all(), (new AddFamilyMember())->rules());
        if ($validator->fails()) {
            return $validator;
        }
        return true;
    }

    private function createFamilyMember(FamilyMember $newMember, Request $request)
    {
        $newMember->user_parent_id = $request->input('customer_id');
        $newMember->first_name = $request->input('first_name');
        $newMember->middle_name = $request->input('middle_name');
        $newMember->last_name = $request->input('last_name');
        $newMember->relation_type = $request->input('relation_type');
        $newMember->mobile_number = $request->input('mobile');
        $newMember->national_id = $request->input('national_id');
        $newMember->address = $request->input('address');
        return $newMember;
    }

    private function uploadMemberImage(Request $request, $fileName, FamilyMember $member){
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
}