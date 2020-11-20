<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\withdraw_amount;
use App\Rules\oneOfPaymentMethods;
use App\Rules\oneOfCurrencies;

class withdrawRequest extends FormRequest
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
            'p_method'   => [
                'required', new oneOfPaymentMethods
            ],

            'currency'   => [
                'required', new oneOfCurrencies($this->request->get('p_method'))
            ],

            'p_info'        => 'string|nullable',

            'amount'        => ['required', 'min:1', 'max:400000', new withdraw_amount(strtolower($this->request->get('p_method').'_'.$this->request->get('currency')))],
        ];
    }
}
