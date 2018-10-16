<?php

namespace App\Http\Requests\CustomerFamily;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddCustomerRequest extends FormRequest
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
            'country_id'            => 'required|integer',
            'city_id'               => 'required|integer',
            'first_name'            => 'required|min:3',
            'middle_name'           => 'required|min:3',
            'last_name'             => 'required|min:3',
            'email'                 => ['required',Rule::unique('customers')->ignore($this->customer,'id')],
            'mobile_number'         => ['required',Rule::unique('customers')->ignore($this->customer,'id')],
            'national_id'           => ['required',Rule::unique('customers')->ignore($this->customer,'id')],
            'address'               => 'required|min:3',
            'profile_picture_path'  => 'sometimes|nullable|required|image|mimes:png,PNG,jpg,jpeg|dimensions:min_width=100,min_height=100',
            'nationality_id_picture'=> 'sometimes|nullable|required|image|mimes:png,PNG,jpg,jpeg|dimensions:min_width=100,min_height=100',
            'gender'                => 'required|integer',
//            'birthdate'             => 'sometimes|nullable|required|date',
            'is_active'             => 'required|integer',
            'is_saudi_nationality'  => 'required|integer',
        ];
    }
}
