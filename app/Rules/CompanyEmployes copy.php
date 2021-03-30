<?php

namespace App\Rules;

use App\Http\Constants\ApiResponse as Api;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Validation\Rule;
use App\Models\User;

class IsSameUser implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
        
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
        return $this->user_id == $value ;
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
                'No tiene permitido operar sobre otros usuarios'
            )
        );
    }
}
