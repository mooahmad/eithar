<?php

namespace App\Http\Requests\Services;

use Illuminate\Foundation\Http\FormRequest;

class CreateServiceRequest extends FormRequest
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
            'parent_cat'             => 'required',
            'country_id'             => 'required',
            'currency_id'            => 'required',
            'type'                   => 'required',
            'type_desc'              => 'required',
            'name_en'                => 'required',
            'name_ar'                => 'required',
            'desc_ar'                => 'required',
            'desc_en'                => 'required',
            'benefits_ar'            => 'required',
            'benefits_en'            => 'required',
            'price'                  => 'required',
            'visit_duration'         => 'required',
            'time_before_next_visit' => 'required',
            'expire_date'            => 'required',
            'is_active'              => 'required',
            'appear_on_website'      => 'required',
            'avatar'     => 'required',
        ];
    }
}
