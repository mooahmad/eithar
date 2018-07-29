<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name'           => 'require',
            'middle_name'          => 'require',
            'last_name'            => 'require',
            'email'                => 'required|unique:customers,email|email',
            'mobile'               => 'required|unique:customers,mobile_number',
            'password'             => 'require',
            'user_type'            => 'require',
            'gender'               => 'require',
            'default_language'     => 'require',
            'birthdate'            => 'require',
            'national_id'          => 'required|unique:users,national_id',
            'nationality_id'       => 'require',
            'is_saudi_nationality' => 'require'
        ];
    }
}
