<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationRequest extends FormRequest
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
            'name'                  => 'required',
            'logo'                  => 'file|image',
            'organization_type_id'  => 'required',
            'causes'                => 'required|min:1',
            'description'           => 'required',
            'email'                 => 'required|email',
            'website'               => '',
            'phones'                => 'required|min:1',
            'phones.*'              => 'required',
            'status'                => 'required:in:active,inactive'
        ];
    }
}
