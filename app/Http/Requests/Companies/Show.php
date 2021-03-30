<?php

namespace App\Http\Requests\Companies;

use Pearl\RequestValidate\RequestAbstract;
use App\Http\Constants\ApiResponse as Api;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Controllers\Controller as Controller;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;


//rules

use App\Rules\HasEitherRole;
use App\Rules\CompanyEmployes;


class Show extends RequestAbstract
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }


    public function all($keys = NULL): array
    {
        $data = parent::all();
        return array_merge(
            $data,
            [
                'requester_id' => Auth::user()->id,
                "company_id" => $this->route('company_id'),
            ]
        );

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {

        
        return [

            'company_id' => [
                'uuid',
                'exists:App\Models\Company,id',
                new HasEitherRole(
                    [
                        Role::SUPERADMIN,
                        Role::OWNER
                    ]
                ),
                (Auth::user()->hasEitherRole([
                    Role::SUPERADMIN
                ])) 
                ?   null
                :   new CompanyEmployes(Auth::user())
  
             ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return[
                        
        ];
    }
    public function failedValidation(Validator $validator): ValidationException
    {
        throw new HttpResponseException(

            Controller::response(
                Api::BAD_REQUEST,
                $validator->errors() 
            )
        );
    }


}
