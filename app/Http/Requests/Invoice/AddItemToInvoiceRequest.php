<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AddItemToInvoiceRequest extends FormRequest
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
        $invoice_id = $this->invoice_id;
        $service_id = $this->service_id;
        return [
//            'invoice_id' => 'required|integer|min:1',
            'service_id' => 'required|integer|min:1',
            'invoice_id'=>[
                'required',
                Rule::unique('invoice_items')->where(function ($query) use($invoice_id,$service_id) {
                    return $query->where('invoice_id', $invoice_id)
                        ->where('service_id', $service_id);
                }),
            ],
        ];
    }
}
