<?php

namespace App\Http\Services\WebApi\UsersModule\ClassesUsers;


use App\Helpers\Utilities;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Customer as CustomerModel;
use Illuminate\Support\Facades\Hash;

class Customer
{
    /**
     * @param $customerAvatar
     * @param Customer $customer
     * @return bool
     */
    public function uploadCustomerAvatar(Request $request, $fileName, CustomerModel $customer)
    {
        if ($request->hasFile($fileName)) {
            $isValidImage = Utilities::validateImage($request, $fileName);
            if (!$isValidImage)
                return false;
            $isUploaded = Utilities::UploadImage($request->file($fileName), 'public/images/avatars');
            if (!$isUploaded)
                return false;
            $customer->profile_picture_path = $isUploaded;
            if (!$customer->save())
                return false;
            return true;
        }
        return true;
    }

    /**
     * @param $nationalIDImage
     * @param Customer $customer
     * @return bool
     */
    public function uploadCustomerNationalIDImage(Request $request, $fileName, CustomerModel $customer)
    {
        if ($request->hasFile($fileName)) {
            $isValidImage = Utilities::validateImage($request, $fileName);
            if (!$isValidImage)
                return false;
            $isUploaded = Utilities::UploadImage($request->file($fileName), 'public/images/nationalities');
            if (!$isUploaded)
                return false;
            $customer->nationality_id_picture = $isUploaded;
            if (!$customer->save())
                return false;
            return true;
        }
        return true;
    }

    /**
     * @param CustomerModel $customer
     * @return bool
     */
    public function updateLastLoginDate(CustomerModel $customer)
    {
        $customer->last_login_date = Carbon::now();
        if (!$customer->save())
            return false;
        return true;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function isCustomerExists(Request $request)
    {
        $customer = CustomerModel::where('email', $request->input('email'))->first();
        if (!$customer)
            return false;
        if (!Hash::check($request->input('password'), $customer->password))
            return false;
        return $customer;
    }
}