<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Service;

class service_quantity implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($service_id)
    {
        $this->service_id = $service_id;
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
        $service_id = $this->service_id;

        $service = Service::find($service_id);
        
        if(!empty($service)){
            $quantity = $service->remaining;
        }else{
            return false;
        }

        return $quantity >= $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The quantity you choosed is greater then original quantity';
    }
}
