<?php

namespace App\Rules;

use App\Http\Constants\ApiResponse as Api;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Validation\Rule;

class SoldByCompany implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($company)
    {
        $this->company = $company;
        
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
        $company = $this->company;

        return $company->sellsProduct($value) ;
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
                'No tiene permitido operar sobre esta compañia'
            )
        );
    }
}
