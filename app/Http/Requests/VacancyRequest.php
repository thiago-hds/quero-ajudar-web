<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VacancyRequest extends FormRequest
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
            'organization_id'       => 'required|exists:organizations,id',
            'name'                  => 'required',
            'image'                 => '',
            'causes'                => 'required|min:1',
            'skills'                => 'required|min:1',
            'description'           => 'required',
            'tasks'                 => 'required',
            'type'                  => 'required:in:recurrent,unique_event',
            'date'                  => 'required_if:type,unique_event|date_format:d/m/Y|after_or_equal:today',
            'hour'                  => 'required_if:type,unique_event|date_format:H:i',
            'promotion_start_date'  => 'nullable|date_format:d/m/Y|after_or_equal:today',
            'promotion_end_date'    => 'nullable|date_format:d/m/Y|after_or_equal:promotion_start_date',
            'enrollment_limit'      => 'nullable|min:1',
            'status'                => 'required:in:active,inactive',
            'address_zipcode'       => 'required',
            'address_street'        => 'required',
            'address_number'        => 'required',
            'address_neighborhood'  => 'required',
            'address_state'         => 'required',
            'address_city'          => 'required|exists:cities,id',
        ];
    }
}
