<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Company;

class BelongsToCompany implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($company_id)
    {

        $this->company = Company::findorfail($company_id);
        
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

        return  $company->hasEmploy($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'No tiene permitido realizar esta accion sobre esta compañia';
    }
}
