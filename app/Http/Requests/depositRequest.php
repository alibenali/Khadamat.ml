<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\oneOfPaymentMethods;
use App\Rules\oneOfCurrencies;

class depositRequest extends FormRequest
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
            'amount'        => 'required|min:1|max:400000',
            'send_date'     => 'required|date|before:tomorrow',
            'img'           => 'image|mimes:jpeg,jpg,png|max:2048'
        ];
    }
}
