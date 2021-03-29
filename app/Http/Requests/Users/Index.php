<?php

namespace App\Http\Requests\Users;

use Pearl\RequestValidate\RequestAbstract;
use App\Http\Constants\ApiResponse as Api;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller as Controller;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

//rules

use App\Rules\HasEitherRole;
use App\Rules\BranchEmployes;
use App\Rules\CompanyEmployes;

class Index extends RequestAbstract
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
                'requester_id' => Auth::user()->id
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
                        Role::ADMIN,
                        Role::SUPERADMIN,
                        Role::OWNER,
                    ]
            )],

            'branch_id' => [
                Rule::requiredIf(
                    Auth::user()->hasEitherRole([
                        Role::ADMIN
                    ])
                ), 
                (Auth::user()->hasEitherRole([
                    Role::SUPERADMIN
                ])) 
                ?   null
                :   new BranchEmployes(Auth::user()->id),


            ],
            'company_id' => [
                Rule::requiredIf(
                    Auth::user()->hasEitherRole([
                        Role::OWNER
                    ])
                ), 
                (Auth::user()->hasEitherRole([
                    Role::SUPERADMIN
                ])) 
                ?   null
                :   new CompanyEmployes(Auth::user()->id),

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
