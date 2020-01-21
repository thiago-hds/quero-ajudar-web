<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
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
            'profile'           => 'required|in:admin,organization',
            'organization_id'   => 'required_if:profile,organization',
            'email'             => 'required|email',
            'password'          => 'required',
            'password_confirm'  => 'required|same:password',
            'status'            => 'required:in:active,inactive'
        ];
    }
}
