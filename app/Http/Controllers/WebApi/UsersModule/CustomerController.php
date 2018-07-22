<?php

namespace App\Http\Controllers\WebApi\UsersModule;

use App\Helpers\ApiHelpers;
use App\Helpers\Utilities;
use App\Http\Services\WebApi\ClassesUsers\CustomerFamilyCrudStrategy;
use App\Http\Services\WebApi\ClassesUsers\CustomerStrategy;
use App\Models\Customer;
use App\Models\FamilyMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function updateCustomerAvatar(Request $request)
    {
        $customer = new CustomerStrategy(ApiHelpers::requestType($request));
        return $customer->uploadCustomerAvatar($request, 'avatar', Customer::find(Auth::user()->id));
    }

    public function updateCustomerNationalId(Request $request)
    {
        $customer = new CustomerStrategy(ApiHelpers::requestType($request));
        return $customer->uploadCustomerNationalIDImage($request, 'nationality_id_picture', Customer::find(Auth::user()->id));
    }

    public function verifyCustomerEmail(Request $request)
    {
        $customer = new CustomerStrategy(ApiHelpers::requestType($request));
        return $customer->verifyCustomerEmail($request);
    }

    public function addCustomerFamilyMember(Request $request)
    {
        $customerFamily = new CustomerFamilyCrudStrategy(ApiHelpers::requestType($request));
        return $customerFamily->addFamilyMember($request);
    }

    public function editCustomerFamilyMember(Request $request)
    {
        $customerFamily = new CustomerFamilyCrudStrategy(ApiHelpers::requestType($request));
        return $customerFamily->editFamilyMember($request);
    }

    public function getCustomerFamilyMember(Request $request)
    {
        $customerFamily = new CustomerFamilyCrudStrategy(ApiHelpers::requestType($request));
        return $customerFamily->getFamilyMember($request);
    }

    public function deleteCustomerFamilyMember(Request $request)
    {
        $customerFamily = new CustomerFamilyCrudStrategy(ApiHelpers::requestType($request));
        return $customerFamily->deleteFamilyMember($request);
    }

    public function getCustomerFamilyMembers(Request $request)
    {
        $customerFamily = new CustomerFamilyCrudStrategy(ApiHelpers::requestType($request));
        return $customerFamily->getFamilyMembers($request);
    }
}
