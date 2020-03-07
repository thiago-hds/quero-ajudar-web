<?php

namespace App\Http\Resources;

use App\Vacancy;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

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
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'description'   => $this->description,
            'type'          => ($this->type == Vacancy::RECURRENT)? "Recorrente" : "Único",
            'tasks'         => $this->tasks,
            'time'          => $this->time,
            'image'         => $this->image? Storage::url($this->image) : null,
            'organization'  => OrganizationResource::make($this->organization),
            'address'       => AddressResource::make($this->address)
        ];
    }
}
