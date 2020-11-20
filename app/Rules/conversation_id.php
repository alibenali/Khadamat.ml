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
        $exist = Conversation::find($value)->count();

        if($exist == 1)
        {
            if(Auth::user()->hasRole('admin')){
                return true;
            }

            if(Auth::id() == $conversation->server_id){
                return true;
            }

            return Auth::user()->id == $conversation->user_id;
        }else{
            return true;
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
