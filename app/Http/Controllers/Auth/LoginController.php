<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ApiHelpers;
use App\Http\Controllers\Controller;
use App\Http\Services\Auth\ClassesAuth\LoginStrategy;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * lockoutTime
     *
     * @var
     */
    protected $lockoutTime = 1;

    /**
     * maxLoginAttempts
     *
     * @var
     */
    protected $maxLoginAttempts = 5;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = AD.'/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * @param Request $request
     */
    public function loginCustomer(Request $request)
    {
        // instantiate login strategy object using request type detection helper method
        $loginStrategy = new LoginStrategy(ApiHelpers::requestType($request));
        return $loginStrategy->loginCustomer($request);
    }

}
