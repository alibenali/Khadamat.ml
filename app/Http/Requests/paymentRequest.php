<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\is_service_id;
use App\Rules\service_quantity;


class paymentRequest extends FormRequest
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
            'service_id' => ['integer', new is_service_id],
            'quantity' => ['required', 'integer', 'min:1', new service_quantity($this->request->get('service_id'))],
        ];
    }
}
