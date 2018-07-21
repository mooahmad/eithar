<?php

namespace App\Http\Controllers\WebApi\UsersModule;

use App\Helpers\ApiHelpers;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public $customer = null;

    public function __construct()
    {
        parent::__construct();
        $this->customer = new \App\Http\Services\WebApi\UsersModule\ClassesUsers\Customer();
    }

    public function updateCustomerAvatar(Request $request)
    {
        $isUploaded = $this->customer->uploadCustomerAvatar($request, 'avatar', Customer::find($request->input('customer_id')));
        if (!$isUploaded)
            return ApiHelpers::fail(config('constants.responseStatus.errorUploadImage'),
                                    new MessageBag([
                                                       "message" => __('errors.errorUploadAvatar')
                                                   ]));
        return ApiHelpers::success(config('constants.responseStatus.success'), new MessageBag([]));
    }

    public function updateCustomerNationalId(Request $request)
    {
        $isUploaded = $this->customer->uploadCustomerNationalIDImage($request, 'nationality_id_picture', Customer::find($request->input('customer_id')));
        if (!$isUploaded)
            return ApiHelpers::fail(config('constants.responseStatus.errorUploadImage'),
                                    new MessageBag([
                                                       "message" => __('errors.errorUploadNationalID')
                                                   ]));
        return ApiHelpers::success(config('constants.responseStatus.success'), new MessageBag([]));
    }
}
