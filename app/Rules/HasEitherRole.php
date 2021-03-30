<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Http\Constants\ApiResponse as Api;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Controllers\Controller;

class HasEitherRole implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($roles)
    {
        $this->roles = $roles;
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
        return Auth::user()->hasEitherRole($this->roles);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        throw new HttpResponseException(

            Controller::response(
                Api::UNAUTHORIZED,
                'No tiene permitido realizar esta accion con su actual rol' 
            )
        );
    }
}
