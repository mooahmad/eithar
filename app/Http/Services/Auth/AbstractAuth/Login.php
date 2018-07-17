<?php

namespace App\Http\Services\Auth\AbstractAuth;

use App\Helpers\Utilities;
use App\Http\Services\Auth\IAuth\ILogin;
use App\Models\Customer;
use Illuminate\Http\Request;

Abstract class Login implements ILogin
{
    public function loginCustomer(Request $request)
    {
        return;
    }
}