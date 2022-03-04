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
            'type'                  => 'required|in:' . RecurrenceType::RECURRENT . ',' . RecurrenceType::UNIQUE_EVENT,
            'status'                => 'required|in:' . StatusType::ACTIVE . ',' . StatusType::INACTIVE,
            'date' => 'date_format:d/m/Y|after:yesterday|nullable',
            'start_time' => 'date_format:H:i|nullable',
            'end_time' => 'date_format:H:i|nullable',
            'location_type'         => 'required',
            'address_zipcode'       => 'required_if:location_type,' . LocationType::SPECIFIC_ADDRESS,
            'address_street'        => 'required_if:location_type,' . LocationType::SPECIFIC_ADDRESS,
            'address_number'        => 'required_if:location_type,' . LocationType::SPECIFIC_ADDRESS,
            'address_neighborhood'  => 'required_if:location_type,' . LocationType::SPECIFIC_ADDRESS,
            'address_state'         => 'required_if:location_type,' . LocationType::SPECIFIC_ADDRESS,
            'address_city'          => 'required_if:location_type,' . LocationType::SPECIFIC_ADDRESS,
        ];

        return $rules;
    }
}
