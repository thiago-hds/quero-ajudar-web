<?php

namespace App\Http\Requests\Api;



class RegisterRequest extends ApiFormRequest
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
            'name'              => 'required',
            'date_of_birth'     => 'required|date_format:d/m/Y|before:today',
            'email'             => 'required|email|unique:users,email',
            'password'          => 'required',
            'password_confirm'  => 'required|same:password',
        ];
    }
}
