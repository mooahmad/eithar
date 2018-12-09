<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class VerifyResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mobile_number'            => 'required',
            'forget_password_code'     => 'required|min:6',
            'password'                 => 'required|min:8|confirmed',
            'password_confirmation'    => 'required|min:8',
        ];
    }
}
