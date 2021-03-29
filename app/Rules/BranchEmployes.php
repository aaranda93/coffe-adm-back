<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\User;

class BranchEmployes implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($user_id)
    {
        $this->user = User::findorfail($user_id);
        
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
        $user = $this->user;

        return $user->belongsToBranch($value) ;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'No tiene permitido realizar esta accion sobre esta sucursal';
    }
}
