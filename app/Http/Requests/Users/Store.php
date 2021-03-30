<?php

namespace App\Http\Requests\Users;

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
            'email' => 'required|email|max:60',
            'phone' => 'required|max:60',
            'birthday' => 'required|date',
            'nid' => 'required|unique:users|cl_rut',
            'forenames' => 'required',
            'surnames' => 'required',
            'password' => 'required|min:8'

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
            'required' => 'El campo es requerido',
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
