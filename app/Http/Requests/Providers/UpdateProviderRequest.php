<?php

namespace App\Http\Requests\Providers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProviderRequest extends FormRequest
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
            'currency_id'            => 'required',
	        'mobile_number'          => ['required',Rule::unique('providers')->ignore($this->provider)],
	        'email'                  => ['required',Rule::unique('providers')->ignore($this->provider)],
            'title_ar'               => 'required',
            'title_en'               => 'required',
            'first_name_ar'          => 'required',
            'first_name_en'          => 'required',
            'last_name_ar'           => 'required',
            'last_name_en'           => 'required',
            'speciality_area_ar'     => 'required',
            'speciality_area_en'     => 'required',
            'rating'                 => 'sometimes|required|numeric|min:0|max:5',
            'price'                  => 'required|numeric|min:0',
            'about_ar'               => 'required',
            'about_en'               => 'required',
            'experience_ar'          => 'required',
            'experience_en'          => 'required',
            'education_ar'           => 'required',
            'education_en'           => 'required',
            'contract_start_date'    => 'sometimes|required',
            'contract_expiry_date'   => 'sometimes|required|after:contract_start_date',
            'visit_duration'         => 'required|numeric|min:0',
            'time_before_next_visit' => 'required|numeric|min:0',
            'avatar'                 => 'mimes:jpeg,bmp,png|dimensions:min_width=100,min_height=100',
        ];
    }
}
