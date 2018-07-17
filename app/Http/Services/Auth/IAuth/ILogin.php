<?php

namespace App\Http\Services\Auth\IAuth;


use Illuminate\Http\Request;

interface ILogin
{
    public function loginCustomer(Request $request);
}