<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ApiHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ProviderLoginRequest;
use App\Http\Services\Auth\ClassesAuth\LoginStrategy;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\http\Request;
use Illuminate\Support\Facades\Auth;

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
     * @return \App\Helpers\ValidationError|string
     */
    public function loginCustomer(Request $request)
    {
        // instantiate login strategy object using request type detection helper method
        $loginStrategy = new LoginStrategy(ApiHelpers::requestType($request));
        return $loginStrategy->loginCustomer($request);
    }

    /**
     * @param Request $request
     * @return \App\Helpers\ValidationError|string
     */
    public function loginProvider(Request $request)
    {
        // instantiate login strategy object using request type detection helper method
        $loginStrategy = new LoginStrategy(ApiHelpers::requestType($request));
        return $loginStrategy->loginProvider($request);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showProviderLogin()
    {
        if (\auth()->guard('provider-web')->user()){
            return back();
        }
        return view('auth.login_provider');
    }

    /**
     * @param ProviderLoginRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function postLoginProvider(ProviderLoginRequest $request)
    {
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if($request->input('remember') ==1)
        {
            $remember = true;
        }else{
            $remember = false;
        }

        if(!Auth::guard('provider-web')->attempt(['mobile_number'=>$request->input('mobile_number'),'password'=>$request->input('password'),'is_active'=>config('constants.provider.active')],$remember))
        {
            $this->incrementLoginAttempts($request);
            session()->flash('error_login',trans('admin.error_login'));
            return back();
        }
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);
//        dd('done');
        return redirect()->route('edit_provider',[Auth::guard('provider-web')->user()->id]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logoutProvider()
    {
        Auth::guard('provider-web')->logout();
        session()->flush();
        return redirect()->route('provider_login');
    }
}
