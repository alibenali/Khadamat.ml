<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Currency;

class oneOfCurrencies implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($p_method)
    {
        $this->p_method = $p_method;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $currencies = Currency::where('name', $value)->where('compatible_with','like', '%'.$this->p_method.'%')->count();

        return $currencies > 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Please select a currency.';
    }
}
