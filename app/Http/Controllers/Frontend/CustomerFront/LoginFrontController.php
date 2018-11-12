<?php

namespace App\Http\Controllers\Frontend\CustomerFront;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CustomerLoginRequest;
use Illuminate\Http\Request;

class LoginFrontController extends Controller
{
    public function __construct()
    {

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showCustomerLogin()
    {
        return view(FE.'.pages.customer.login');
    }

    public function customerLogin(CustomerLoginRequest $request)
    {
        return $request->all();
    }
}
