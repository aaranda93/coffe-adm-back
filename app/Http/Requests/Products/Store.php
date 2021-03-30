<?php

namespace App\Http\Requests\Products;

use Pearl\RequestValidate\RequestAbstract;
use App\Http\Constants\ApiResponse as Api;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller as Controller;

//rules

use App\Rules\HasEitherRole;
use App\Rules\CompanyEmployes;

class Store extends RequestAbstract
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
            'requester_id' => [
                new HasEitherRole(
                    [
                        Role::SUPERADMIN,
                        Role::OWNER,
                    ]
                )
            ],
            'company_id' => [
                'uuid',
                'exists:App\Models\Company,id',
                (Auth::user()->hasEitherRole([
                    Role::SUPERADMIN
                ])) 
                ?   null
                :   new CompanyEmployes(Auth::user())

            ],
            'name' => 'required',
            'status' => 'integer|between:0,1'

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
                        
            'status.between' => 'Status invalido',
            'status.integer' => 'Status invalido',
            'required' => 'El campo es requerido',
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
