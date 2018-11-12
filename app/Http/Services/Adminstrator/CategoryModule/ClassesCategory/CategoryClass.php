<?php

namespace App\Http\Services\Adminstrator\CategoryModule\ClassesCategory;


use App\Helpers\Utilities;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;

class CategoryClass
{

    public static function createOrUpdate(Category $category, $request, $isCreate = true)
    {
        $category->category_parent_id = $request->input('parent_cat');
        $category->category_name_en = $request->input('name_en');
        $category->category_name_ar = $request->input('name_ar');
        $category->description_en = $request->input('desc_en');
        $category->description_ar = $request->input('desc_ar');
        if($isCreate)
            $category->added_by = Auth::id();
        return $category->save();
    }

    /**
     * @param Request $request
     * @param $fileName
     * @param $path
     * @param category $category
     * @return mixed
     */
    public static function uploadImage(Request $request, $fileName, $path, Category $category, $fieldName)
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
            Utilities::DeleteFile($category->{$fieldName});
            $category->{$fieldName} = $isUploaded;
            if (!$category->save())
                return Utilities::getValidationError(config('constants.responseStatus.errorUploadImage'),
                                                     new MessageBag([
                                                                        "message" => trans('errors.errorUploadAvatar')
                                                                    ]));
            return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));
        }
        return Utilities::getValidationError(config('constants.responseStatus.success'), new MessageBag([]));
    }

}