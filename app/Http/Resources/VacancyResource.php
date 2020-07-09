<?php

namespace App\Http\Resources;

use App\Vacancy;
use App\Organization;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class VacancyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $array = [
            'id'                    => $this->id,
            'name'                  => $this->name,
            'description'           => $this->description,
            'type'                  => $this->type,
            'tasks'                 => $this->tasks,
            'image'                 => $this->image? Storage::url($this->image) : null,
            'organization'          => OrganizationResource::make($this->organization),
            'causes'                => CauseResource::collection($this->causes),
            'skills'                => SkillResource::collection($this->skills),
            'periodicity'           => $this->periodicity,
            'amount_per_period'     => $this->amount_per_period,
            'unit_per_period'       => $this->unit_per_period,
            'date'                  => $this->date,
            'time'                  => $this->time,
            'location_type'         => $this->location_type,
            'address'               =>  null,
            'formatted_frequency'   => $this->getFormattedFrequency(),
            'formatted_date'        => $this->getFormattedDate(),
            'formatted_time'        => $this->getFormattedTime(),
            'formatted_location'    => $this->getFormattedLocation(),
            'favorited'             => null
        ];

        if($this->location_type == Vacancy::SPECIFIC_ADDRESS){
            $array['address'] = AddressResource::make($this->address);
        }
        else if($this->location_type == Vacancy::ORGANIZATION_ADDRESS
            && $organization = Organization::find($this->organization_id)){
                $array['address'] = AddressResource::make($organization->address);
        }

        if($user = Auth::user()){
            $count = $this->favorites()->where('volunteer_id',$user->id)->count();
            $array['favorited'] = $count > 0? true : false;
        }


        return $array;
    }
}
