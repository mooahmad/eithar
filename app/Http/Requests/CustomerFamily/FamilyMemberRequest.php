<?php

namespace App\Http\Requests\CustomerFamily;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FamilyMemberRequest extends FormRequest
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
            'user_parent_id'        => 'required|integer',
            'first_name'            => 'required|min:3',
            'middle_name'           => 'required|min:3',
            'last_name'             => 'required|min:3',
            'relation_type'         => 'required|integer',
            'mobile_number'         => ['required',Rule::unique('family_members')->ignore($this->family,'id')],
            'national_id'           => ['required',Rule::unique('family_members')->ignore($this->family,'id')],
            'address'               => 'required|min:3',
            'profile_picture_path'  => 'sometimes|nullable|required|image|mimes:png,PNG,jpg,jpeg|dimensions:min_width=100,min_height=100',
            'gender'                => 'required|integer',
//            'birthdate'             => 'sometimes|nullable|required|date',
            'is_active'             => 'required|integer',
            'is_saudi_nationality'  => 'required|integer',
        ];
    }
}
