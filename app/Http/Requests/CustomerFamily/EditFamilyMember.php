<?php

namespace App\Http\Requests\CustomerFamily;

use Illuminate\Foundation\Http\FormRequest;

class EditFamilyMember extends FormRequest
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
            'member_id'     => 'required',
            'first_name'    => 'required',
            'middle_name'   => 'required',
            'last_name'     => 'required',
            'relation_type' => 'required',
            'mobile'        => 'required',
            'national_id'   => 'required',
            'address'       => 'required'
        ];
    }
}
