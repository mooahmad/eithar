<?php

namespace App\Http\Controllers\Frontend\CustomerFront;

use App\Helpers\Utilities;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CustomerLoginRequest;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginFrontController extends Controller
{
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
    protected $redirectTo = '/';

    public function __construct()
    {
        //
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showCustomerLogin()
    {
        if (auth()->guard('customer-web')->check()){
            return back();
        }
        return view(FE.'.pages.customer.login');
    }

    /**
     * @param CustomerLoginRequest $request
     * @return \Illuminate\Http\RedirectResponse|void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function customerLogin(CustomerLoginRequest $request)
    {
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if($request->input('remember_me') ==1)
        {
            $remember = true;
        }else{
            $remember = false;
        }

        $mobile = Utilities::AddCountryCodeToMobile($request->input('mobile_number'));

        if(!Auth::guard('customer-web')->attempt(['mobile_number'=>$mobile,'password'=>$request->input('password')],$remember))
        {
            $this->incrementLoginAttempts($request);
            session()->flash('error_login',trans('main.error_login'));
            return back();
        }

        $this->updateCustomerLastLogin();

        $request->session()->regenerate();
        $this->clearLoginAttempts($request);
        return redirect()->route('home');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logoutCustomer()
    {
        Auth::guard('customer-web')->logout();
        session()->flush();
        return redirect()->route('home');
    }

    /**
     * @return mixed
     */
    public function updateCustomerLastLogin()
    {
        return Customer::where('id',Auth::guard('customer-web')->user()->id)
            ->update([
            'last_login_date'=>Carbon::now()
        ]);
    }
}
