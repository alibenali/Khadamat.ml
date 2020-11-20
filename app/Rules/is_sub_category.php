<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\service_sub_category;

class is_sub_category implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($category)
    {
        $this->category = $category;
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
        $count = service_sub_category::where('slug_name', $value)->where('cat_slug', $this->category)->count();

        return $count == 1;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Their is no sub category with this name';
    }
}
