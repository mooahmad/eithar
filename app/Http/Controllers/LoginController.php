<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * lockoutTime
     *
     * @var
     */
    protected $lockoutTime;

    /**
     * maxLoginAttempts
     *
     * @var
     */
    protected $maxLoginAttempts;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = AD.'/home';
    /**
     * LoginController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest')->except(AD.'/logout');
        $this->lockoutTime  = 1;    //lockout for 1 minute (value is in minutes)
        $this->maxLoginAttempts = 5;    //lockout after 5 attempts
    }

    /**
     * Determine if the user has too many failed login attempts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function hasTooManyLoginAttempts(Request $request)
    {
        return $this->limiter()->tooManyAttempts(
            $this->throttleKey($request), $this->maxLoginAttempts, $this->lockoutTime
        );
    }

    /**
     * Display admin login blade
     */
    public function login()
    {
        $data = [
            'submit_button'=>trans('admin.login')
        ];
        return view('login')->with($data);
    }

    /**
     * Check if this user already exist in database or not.
     */
    public function checkLogin(Request $request)
    {
        $rules = [
            'email'                 => 'required|email',
            'password'              => 'required',
        ];
        $validator = Validator::make($request->all(),$rules);
        $validator->SetAttributeNames([
            'email'                 => trans('admin.email'),
            'password'              => trans('admin.password'),
        ]);
        if($validator->fails())
        {
            return back()->withInput()->withErrors($validator);
        }else{

            // 2) Check if the user has surpassed their allowed maximum of login attempts
            // We'll key this by the username and the IP address of the client making
            // these requests into this application.
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

            if(Auth::attempt(['email'=>$request->input('email'),'password'=>$request->input('password'),'is_active'=>1],$remember))
            {
                // SUCCESS: If the login attempt was successful we redirect to the dashboard. but first, we
                // clear the login attempts session
                $request->session()->regenerate();
                $this->clearLoginAttempts($request);

                return redirect(AD.'/home');
            }else{
                // FAIL: If the login attempt was unsuccessful we will increment the number of attempts
                // to login and redirect the user back to the login form. Of course, when this
                // user surpasses their maximum number of attempts they will get locked out.
                $this->incrementLoginAttempts($request);

                session()->flash('error_login',trans('admin.error_login'));
                return back();
            }
        }
    }
}
