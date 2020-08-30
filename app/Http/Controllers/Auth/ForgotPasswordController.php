<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Utilities;
use App\Http\Controllers\Controller;
use App\Mail\Customer\ForgetPasswordMail;
use App\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendAdminForget(Request $request)
    {
        $request->validate([
                               'email' => 'required:email',
                           ]);
        $user = User::where('email', $request->input('email'))->first();
        if ($user) {
            $user->forget_password_code = Utilities::quickRandom(6, true);
            $user->save();
            Mail::to($user->email)->send(new ForgetPasswordMail($user));
        }
        return redirect()->route('adminReset');
    }

    public function resetAdminForget(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code'     => 'required',
            'email'    => 'required:email',
            'password' => 'required'
        ]);

        $user = User::where([
                                ['email', $request->input('email')],
                                ['forget_password_code', $request->input('code')]
                            ])->first();

        $validator->after(function ($validator) use ($user) {
            if (!$user) {
                $validator->errors()->add('code', 'wrong code or email!');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect()->route('login');
    }
}
