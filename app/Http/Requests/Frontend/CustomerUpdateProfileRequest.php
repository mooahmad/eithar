<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerUpdateProfileRequest extends FormRequest
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
            'first_name'            => 'required|min:3|max:50',
            'middle_name'           => 'required|min:3|max:50',
            'last_name'             => 'required|min:3|max:50',
            'gender'                => 'required|integer',
            'country_id'            => 'required|integer',
            'city_id'               => 'required|integer',
            'address'               => 'required|min:3|max:150',
            'position'              => 'required|max:100',
            'email'                 => ['required',Rule::unique('customers')->ignore($this->id,'id')],
            'mobile_number'         => ['required',Rule::unique('customers')->ignore($this->id,'id')],
            'national_id'           => ['required',Rule::unique('customers')->ignore($this->id,'id')],
            'profile_picture_path'  => 'sometimes|nullable|required|image|mimes:png,PNG,jpg,jpeg|dimensions:min_width=100,min_height=100',
            'nationality_id_picture'=> 'sometimes|nullable|required|image|mimes:png,PNG,jpg,jpeg|dimensions:min_width=100,min_height=100',
        ];
    }
}
