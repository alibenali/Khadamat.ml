<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\is_category;
use App\Rules\is_sub_category;
use App\Rules\oneOfPaymentMethods;
use App\Rules\oneOfCurrencies;

class serviceRequest extends FormRequest
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
                'title'           => 'required|min:3|max:150',
                'category'        => ['required','string', new is_category],
                'sub_category'    => ['required', 'string', new is_sub_category($this->request->get('category'))],
                'price'           => 'required|integer',
                'p_method'        => ['required','string', new oneOfPaymentMethods],
                'currency'        => ['required','string', new oneOfCurrencies($this->request->get('p_method'))],
                'duration'        => 'required|integer',
                'remaining'       => 'required|integer',
                'desc'            => 'required|string',
                'image'           => 'nullable|image|mimes:jpeg,jpg,png|max:2048'
            ];

 
    }
}
