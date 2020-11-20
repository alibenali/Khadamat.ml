<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class profileRequest extends FormRequest
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
            'name'          => 'required|min:2|regex:/^[\pL\s\-]+$/u',
            'phone'         => 'numeric|digits:8|nullable',
            'phone_country' => 'numeric|digits:2|nullable',
            'email'         => 'required|email',
            'birthdate'     => 'date|nullable',
            'address'       => 'string|min:5|max:200|nullable'
        ];
    }
}
