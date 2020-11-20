<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\is_service_id;
use App\Rules\conversation_id;

class ratingRequest extends FormRequest
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
            'conversation_id' => ['integer', new conversation_id],
            'comment' => 'string',
            'num_stars' => 'integer|max:5|min:1',
        ];
    }
}
