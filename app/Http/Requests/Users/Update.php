<?php

namespace App\Http\Requests\Users;

use Pearl\RequestValidate\RequestAbstract;
use App\Http\Constants\ApiResponse as Api;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Controllers\Controller as Controller;

//Rules

use App\Rules\BelongsToBranch;

class Update extends RequestAbstract
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
        return array_push(
            parent::all(),
            [
                "user_id" => $this->route('user_id'),
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
            'user_id' => [
                (Auth::user()->hasEitherRole([
                    Role::SUPERADMIN
                ])) 
                ?   null
                :   (Auth::user()->hasEitherRole([
                        Role::ADMIN
                    ])) 
                    ? new BelongsToBranch(Auth::user()->branch->id)
                    : new BelongsToCompany(Auth::user()->company->id)
             ],
            'email' => 'email|max:60',
            'phone' => 'max:60',
            'birthday' => 'date',
            'nid' => 'unique:users|cl_rut',
            'password' => 'min:8'
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
                        
            'nid.cl_rut' => 'El rut debe ser válido',
            'nid.unique' => 'El rut ya está registrado',
            'birthday.date' => 'La fecha de nacimiento debe ser una fecha valida',
            'password.min' => 'La contraseña debe contener por lo menos 8 caracteres',
            'email.max' => 'El campo tiene un largo máximo de 60 caracteres',
            'email'      => 'El correo debe ser un correo válido',
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
