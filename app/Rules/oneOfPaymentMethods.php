<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\PaymentMethod;

class oneOfPaymentMethods implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $payment_methods = PaymentMethod::where('name', $value)->count();

        return $payment_methods > 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Please select a payment method.';
    }
}
