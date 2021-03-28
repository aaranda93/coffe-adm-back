<?php

namespace App\Http\Requests;

use App\Http\Constants\ApiResponse as Api;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use App\Http\Controllers\Controller as Controller;


class StoreUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
  
        return [
            
            'email' => 'email|max:60',
            'phone' => 'max:60',
            'birthday' => 'date',
            'nid' => 'unique:users|cl_rut',
            'password' => 'min:8'
           
        ];
    }

    public function messages()
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

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(

            Controller::response(
                Api::BAD_REQUEST,
                $validator->errors() 
            )
        );
    }
}
