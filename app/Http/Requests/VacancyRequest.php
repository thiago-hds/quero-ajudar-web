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
            'organization'          => 'required',
            'name'                  => 'required',
            'image'                 => 'file|image',
            'causes'                => 'required|min:1',
            'skills'                 => 'required|min:1',
            'description'           => 'required',
            'tasks'                 => 'required',
            'type'                  => 'required:in:recurrent,unique_event',
            'date'                  => '',
            'hour'                  => '',
            'promotion_start_date'  => '',
            'promotion_end_date'    => '',
            'enrollment_limit'      => '',
            'status'                => 'required:in:active,inactive',
            'address_zipcode'       => 'required',
            'address_street'        => 'required',
            'address_number'        => 'required',
            'address_neighborhood'  => 'required',
            'address_state'         => '',
            'address_city'          => '',
        ];
    }
}
