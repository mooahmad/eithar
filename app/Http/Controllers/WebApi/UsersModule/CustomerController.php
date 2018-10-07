<?php

namespace App\Http\Controllers\WebApi\UsersModule;

use App\Helpers\ApiHelpers;
use App\Http\Services\WebApi\ClassesUsers\CustomerFamilyCrudStrategy;
use App\Http\Services\WebApi\ClassesUsers\CustomerStrategy;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function editCustomer(Request $request)
    {
        $customer = new CustomerStrategy(ApiHelpers::requestType($request));
        return $customer->editCustomer($request);
    }

    public function verifyCustomerEmail(Request $request)
    {
        $customer = new CustomerStrategy(ApiHelpers::requestType($request));
        return $customer->verifyCustomerEmail($request);
    }

    public function resendEmailVerificationCode(Request $request)
    {
        $customer = new CustomerStrategy(ApiHelpers::requestType($request));
        return $customer->resendEmailVerificationCode($request);
    }

    public function forgetPassword(Request $request)
    {
        $customer = new CustomerStrategy(ApiHelpers::requestType($request));
        return $customer->forgetPassword($request);
    }

    public function updateForgottenPassword(Request $request)
    {
        $customer = new CustomerStrategy(ApiHelpers::requestType($request));
        return $customer->updateForgottenPassword($request);
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

    public function getCustomerAppointments(Request $request)
    {
        $customer = new CustomerStrategy(ApiHelpers::requestType($request));
        return $customer->getCustomerAppointments($request);
    }

    public function getCustomerAppointment(Request $request, $id, $serviceType)
    {
        $customer = new CustomerStrategy(ApiHelpers::requestType($request));
        return $customer->getCustomerAppointment($request, $id, $serviceType);
    }

    public function getCustomerNotifications(Request $request)
    {
        $customer = new CustomerStrategy(ApiHelpers::requestType($request));
        return $customer->getCustomerNotifications($request);
    }

    public function getCustomerMedicalReports(Request $request)
    {
        $customer = new CustomerStrategy(ApiHelpers::requestType($request));
        return $customer->getCustomerMedicalReports($request);
    }

    public function confirmBookingItem(Request $request, $itemId)
    {
        $customer = new CustomerStrategy(ApiHelpers::requestType($request));
        return $customer->confirmBookingItem($request, $itemId);
    }

    public function search(Request $request, $keyword)
    {
        $customer = new CustomerStrategy(ApiHelpers::requestType($request));
        return $customer->search($request, $keyword);
    }

    public function logoutCustomer(Request $request)
    {
        // instantiate login strategy object using request type detection helper method
        $loginStrategy = new CustomerStrategy(ApiHelpers::requestType($request));
        return $loginStrategy->logoutCustomer($request);
    }
}
