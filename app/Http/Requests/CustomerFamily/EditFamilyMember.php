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
    public function rules($id)
    {
        return [
            'member_id'     => 'required',
            'first_name'    => 'required',
            'middle_name'   => 'required',
            'last_name'     => 'required',
            'relation_type' => 'required',
            'mobile'        => 'required|unique:family_members,mobile_number,'.$id.'',
            'national_id'   => 'required|unique:family_members,national_id, '.$id.'',
            'address'       => 'required'
        ];
    }
}
