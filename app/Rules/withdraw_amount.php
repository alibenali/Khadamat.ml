<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Balance;
use Auth;

class withdraw_amount implements Rule
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
        $balance = Balance::where('user_id', Auth::id())->get()->first();
        $p_method = $this->p_method;
        
        return $balance->$p_method >= $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'You don\'t have this amount in your balance.';
    }
}
