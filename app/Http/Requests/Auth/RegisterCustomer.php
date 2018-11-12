<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterCustomer extends FormRequest
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
    public function rules($customerID)
    {
        return [
            'first_name'  => 'required',
            'middle_name' => 'required',
            'last_name'   => 'required',
            'email'       => 'required|unique:customers,email, '.$customerID.'|email',
            'mobile'      => 'required|unique:customers,mobile_number, '.$customerID.'',
            'password'    => 'required',
            'gender'      => 'required',
            'national_id' => 'required|unique:customers,national_id, '.$customerID.'',
            'country_id'  => 'required',
            'city_id'     => 'required',
            'position'    => 'required',
            'address'     => 'required'
        ];
    }
}
