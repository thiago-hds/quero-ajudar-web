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
            'name'                  => 'required|unique:organization',
            'organization_type_id'  => 'required',
            'description'           => 'required',
            'logo'                  => 'required',
            'website'               => 'required',
            'status'                => 'required:in:active,inactive'
        ];
    }
}
