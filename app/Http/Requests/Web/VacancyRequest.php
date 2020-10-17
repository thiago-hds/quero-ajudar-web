<?php

namespace App\Http\Requests\Web;

use App\Enums\LocationType;
use App\Enums\PeriodicityType;
use App\Enums\RecurrenceType;
use App\Enums\StatusType;
use App\Enums\UnitPerPeriodType;
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
            'type'                  => 'required|in:'. RecurrenceType::RECURRENT.','. RecurrenceType::UNIQUE_EVENT,
            'promotion_start_date'  => 'nullable|date_format:d/m/Y|after_or_equal:today',
            'promotion_end_date'    => 'nullable|date_format:d/m/Y|after_or_equal:promotion_start_date',
            'application_limit'     => 'nullable|min:1',
            'status'                => 'required|in:' . StatusType::ACTIVE . ',' . StatusType::INACTIVE,
            'address_zipcode'       => 'required_if:location_type,' . LocationType::SPECIFIC_ADDRESS,
            'address_street'        => 'required_if:location_type,' . LocationType::SPECIFIC_ADDRESS,
            'address_number'        => 'required_if:location_type,' . LocationType::SPECIFIC_ADDRESS,
            'address_neighborhood'  => 'required_if:location_type,' . LocationType::SPECIFIC_ADDRESS,
            'address_state'         => 'required_if:location_type,' . LocationType::SPECIFIC_ADDRESS,
            'address_city'          => 'required_if:location_type,' . LocationType::SPECIFIC_ADDRESS,
        ];
        
        $type                   = $this->request->get('type');
        $frequency_negotiable   = $this->request->get('frequency_negotiable');
        $hours_negotiable       = $this->request->get('hours_negotiable');
        $unit_per_period        = $this->request->get('unit_per_period');

        if($type == RecurrenceType::RECURRENT && $frequency_negotiable == 'no'){
            
            $rules['periodicity']           = 'required|in:' . PeriodicityType::DAILY . ',' . PeriodicityType::WEEKLY . ',' . PeriodicityType::MONTHLY;
            
            if($unit_per_period == UnitPerPeriodType::DAYS){
                $rules['unit_per_period']       = 'required|in:' . UnitPerPeriodType::HOURS;
            }
            else{
                $rules['unit_per_period']       = 'required|in:' . UnitPerPeriodType::HOURS . ',' . UnitPerPeriodType::DAYS;
            }
            $rules['amount_per_period']     = 'required|min:1|max:31';
        
        }

        if($hours_negotiable == 'no'){

            $rules['date']          = 'required_if:type,'. RecurrenceType::UNIQUE_EVENT .'|date_format:d/m/Y|after_or_equal:today';
            $rules['time']          = 'required|date_format:H:i';
        }

        return $rules;
    }

}
