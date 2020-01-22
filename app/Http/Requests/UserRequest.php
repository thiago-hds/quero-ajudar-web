<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
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
        
        $rules = [
            'name'              => 'required',
            'date_of_birth'     => 'required|date_format:d/m/Y|before:today',
            'email'             => 'required|email',
            'password'          => 'required',
            'password_confirm'  => 'required|same:password',
            'status'            => 'required:in:active,inactive'
        ];

        if(Auth::user()->isAdmin()){
            $rules [] = [[
                'profile'           => 'required|in:admin,organization',
                'organization_id'   => 'required_if:profile,organization',
            ]];
        }
        
        return $rules;
    }
}
