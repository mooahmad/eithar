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

    public function getCustomerAppointments(Request $request)
    {
        return $this->strategy->getCustomerAppointments($request);
    }

    public function getCustomerAppointment(Request $request)
    {
        return $this->strategy->getCustomerAppointment($request);
    }
}