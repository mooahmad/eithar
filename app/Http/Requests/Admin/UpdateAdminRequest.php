<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
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
            'first_name'           => 'required',
            'middle_name'          => 'required',
            'last_name'            => 'required',
            'email'                => 'required|unique:users,email, ' . $this->route()->parameters()['admin'] . '|email',
            'mobile'               => 'required|unique:users,mobile_number, ' . $this->route()->parameters()['admin'],
            'password'             => 'sometimes|nullable|max:15',
            'user_type'            => 'required',
            'gender'               => 'required',
            'default_language'     => 'required',
            'birthdate'            => 'required',
            'national_id'          => 'required|unique:users,national_id, ' . $this->route()->parameters()['admin'],
            'nationality_id'       => 'required',
            'is_saudi_nationality' => 'required',
            'avatar'               => 'mimes:jpeg,bmp,png|dimensions:min_width=100,min_height=200'
        ];
    }
}
