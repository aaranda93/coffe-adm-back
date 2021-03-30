<?php

namespace App\Http\Requests\Products;

use Pearl\RequestValidate\RequestAbstract;
use App\Http\Constants\ApiResponse as Api;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Controllers\Controller as Controller;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

//Rules


use App\Rules\SoldByCompany;
use App\Rules\HasEitherRole;


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
        $data = parent::all();
        return array_merge(
            $data,
            [
                'requester_id' => Auth::user()->id,
                "product_id" => $this->route('product_id'),
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
            )],
            'product_id' => [
                'uuid',
                'exists:App\Models\Company,id',
                (Auth::user()->hasEitherRole([
                    Role::SUPERADMIN
                ])) 
                ?   null
                :   new SoldByCompany(Auth::user()->company)
  
             ],
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
                        
            'user_id.exists' => 'El usuario ingresado no existe',
            'nid.unique' => 'El rut ingresado ya se encuentra usado',
            'email.unique' => 'El email ingresado ya se encuentra usado'
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
