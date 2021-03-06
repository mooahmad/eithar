<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PayInvoiceRequest extends FormRequest
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
        $rules = [
            'payment_method'=>[
                'required',
                'integer',
                Rule::in([1,2,3,4]),
            ],
            'invoice_id'=>'required|integer',
        ];
        if ($this->payment_method !=1){
            $rules['payment_transaction_number']='required';

        }
        if (auth()->guard('provider-web')->user()){
            $rules['provider_comment']='required|min:2';
        }
        if (auth()->user()){
            $rules['admin_comment']='required|min:2';
        }
        return $rules;
    }
}
