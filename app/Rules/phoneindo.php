<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class phoneindo implements Rule
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
        return
            preg_match('/^(^\+62\s?|^0)(\d{3,4}-?){2}\d{3,4}$/', $value) && strlen($value) >= 10;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Nomor bukan nomor telp indonesia.';
    }
}
