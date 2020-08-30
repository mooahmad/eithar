<?php

namespace App\Http\Services\WebApi\ClassesUsers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerStrategy
{
    private $strategy = NULL;

    public function __construct($strategyType) {
        switch ($strategyType) {
            case config('constants.requestTypes.web'):
                $this->strategy = new CustomerWeb();
                break;
            case config('constants.requestTypes.api'):
                $this->strategy = new CustomerApi();
                break;
        }
    }

    public function uploadCustomerAvatar(Request $request, $fileName, Customer $customer)
    {
        return $this->strategy->uploadCustomerAvatar($request, $fileName, $customer);
    }

    public function uploadCustomerNationalIDImage(Request $request, $fileName, Customer $customer)
    {
        return $this->strategy->uploadCustomerNationalIDImage($request, $fileName, $customer);
    }

    public function editCustomer(Request $request)
    {
        return $this->strategy->editCustomer($request);
    }

    public function updateLastLoginDate(Customer $customer)
    {
        return $this->strategy->updateLastLoginDate($customer);
    }

    public function isCustomerExists(Request $request)
    {
        return $this->strategy->isCustomerExists($request);
    }

    public function verifyCustomerEmail(Request $request)
    {
        return $this->strategy->verifyCustomerEmail($request);
    }

    public function forgetPassword(Request $request)
    {
        return $this->strategy->forgetPassword($request);
    }

    public function updateForgottenPassword(Request $request)
    {
        return $this->strategy->updateForgottenPassword($request);
    }

    public function resendEmailVerificationCode(Request $request)
    {
        return $this->strategy->resendEmailVerificationCode($request);
    }

    public function getCustomerAppointments(Request $request, $page = 1)
    {
        return $this->strategy->getCustomerAppointments($request, $page);
    }

    public function getCustomerAppointment(Request $request, $id, $serviceType)
    {
        return $this->strategy->getCustomerAppointment($request, $id, $serviceType);
    }

    public function getCustomerNotifications(Request $request, $page = 1)
    {
        return $this->strategy->getCustomerNotifications($request, $page);
    }

    public function getCustomerMedicalReports(Request $request)
    {
        return $this->strategy->getCustomerMedicalReports($request);
    }

    public function search(Request $request, $keyword)
    {
        return $this->strategy->search($request, $keyword);
    }

    public function logoutCustomer(Request $request)
    {
        return $this->strategy->logoutCustomer($request);
    }
}