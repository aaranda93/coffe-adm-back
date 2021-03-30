<?php

namespace App\Rules;
use App\Http\Constants\ApiResponse as Api;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Validation\Rule;
use App\Models\Branch;

class BelongsToBranch implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($branch_id)
    {

        $this->branch = Branch::findorfail($branch_id);
        
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
        $branch = $this->branch;

        return  $branch->hasEmploy($value);
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
                'No tiene permitido realizar esta accion sobre usuarios de esta sucursal' 
            )
        );
    
    }
}
