<?php

namespace App\Http\Controllers\Frontend\CustomerFront;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SignUpFrontController extends Controller
{
    /**
     * SignUpFrontController constructor.
     */
    public function __construct()
    {
        $this->middleware(['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showCustomerSignUp()
    {
        return view(FE.'.pages.customer.sign_up');
    }
}
