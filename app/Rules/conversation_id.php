<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Conversation;
use Auth;

class conversation_id implements Rule
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
        $conversation = Conversation::find($value);

        if(!empty($conversation))
        {
            if(Auth::user()->is_admin){
                return true;
            }
            return Auth::user()->id == $conversation->user_id;
        }else{
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This conversation is not for you.';
    }
}
