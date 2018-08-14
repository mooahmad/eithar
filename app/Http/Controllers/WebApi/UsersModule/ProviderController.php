<?php

namespace App\Http\Controllers\WebApi\UsersModule;

use App\Helpers\ApiHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ProviderController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getProvider(Request $request)
    {
        $customer = new CustomerStrategy(ApiHelpers::requestType($request));
        return $customer->uploadCustomerAvatar($request, 'avatar', Customer::find(Auth::user()->id));
    }

}
