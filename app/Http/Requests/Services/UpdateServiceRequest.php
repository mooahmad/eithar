<?php

namespace App\Http\Requests\Services;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
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
            'price'                  => 'required|numeric',
            'visit_duration'         => 'required|numeric',
            'time_before_next_visit' => 'required|numeric',
            'expiry_date'            => 'required',
            'is_active'              => 'required',
            'appear_on_website'      => 'required',
            'avatar'                 => 'mimes:jpeg,bmp,png|dimensions:min_width=100,min_height=100'
        ];
    }
}
