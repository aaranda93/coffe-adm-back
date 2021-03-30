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
use App\Rules\IsSameUser;

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

            'user_id' => [
                'exists:App\Models\User,id',
                (Auth::user()->hasEitherRole([
                    Role::SUPERADMIN
                ])) 
                ?   null
                :   (Auth::user()->hasEitherRole([
                        Role::OWNER
                    ])) 
                    ?   new BelongsToCompany(Auth::user()->company)
                    :   (Auth::user()->hasEitherRole([
                            Role::ADMIN
                        ])) 
                        ?   new BelongsToBranch(Auth::user()->branch)
                        :   new IsSameUser(Auth::user()->id)
  
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
