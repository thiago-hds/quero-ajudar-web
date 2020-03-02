<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class VolunteerRequest extends FormRequest
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
            'first_name'        => 'required',
            'last_name'         => 'required',
            'date_of_birth'     => 'required|date_format:d/m/Y|before:today',
            'email'             => 'required|email',
            'password'          => 'required',
            'password_confirm'  => 'required|same:password',
            'status'            => 'required:in:active,inactive',
            'causes'            => 'nullable',
            'skills'            => 'nullable',
        ];
    }
}
