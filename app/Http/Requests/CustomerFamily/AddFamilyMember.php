<?php

namespace App\Http\Requests\CustomerFamily;

use Illuminate\Foundation\Http\FormRequest;

class AddFamilyMember extends FormRequest
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
            'first_name'    => 'required',
            'middle_name'   => 'required',
            'last_name'     => 'required',
            'relation_type' => 'required',
//            'mobile'        => 'required|unique:family_members,mobile_number',
            'mobile'        => 'required',
            'national_id'   => 'required|unique:family_members,national_id',
            'address'       => 'required'
        ];
    }
}
