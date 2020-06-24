<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Api\ApiFormRequest;
use App\Vacancy;

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
        $rules = [
            'organization_id'       => 'required|exists:organizations,id',
            'name'                  => 'required',
            'image'                 => 'image',
            'causes'                => 'nullable',
            'skills'                => 'nullable',
            'description'           => 'required',
            'tasks'                 => 'required',
            'type'                  => 'required|in:recurrent,unique_event',
            'promotion_start_date'  => 'nullable|date_format:d/m/Y|after_or_equal:today',
            'promotion_end_date'    => 'nullable|date_format:d/m/Y|after_or_equal:promotion_start_date',
            'enrollment_limit'      => 'nullable|min:1',
            'status'                => 'required|in:active,inactive',
            'address_zipcode'       => 'required_if:location_type,specific_address',
            'address_street'        => 'required_if:location_type,specific_address',
            'address_number'        => 'required_if:location_type,specific_address',
            'address_neighborhood'  => 'required_if:location_type,specific_address',
            'address_state'         => 'required_if:location_type,specific_address',
            'address_city'          => 'required_if:location_type,specific_address|exists:cities,id',
        ];
        
        $type                   = $this->request->get('type');
        $frequency_negotiable   = $this->request->get('frequency_negotiable');
        $hours_negotiable       = $this->request->get('hours_negotiable');

        if($type == 'recurrent' && $frequency_negotiable == 'no'){
            
            $rules['periodicity']           = 'required|in:daily,weekly,monthly';
            $rules['unit_per_period']       = 'required|in:days,months';
            $rules['amount_per_period']     = 'required|min:1|max:31';
        
        }

        if($hours_negotiable == 'no'){

            $rules['date']          = 'required_if:type,unique_event|date_format:d/m/Y|after_or_equal:today';
            $rules['start_time']    = 'required|date_format:H:i';
        }

        return $rules;
    }

}
