<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'street'        => $this->street,
            'number'        =>$this->number,
            'neighborhood'  => $this->neighborhood,
            'zipcode'       => $this->zipcode,
            'city'          => $this->city->name,
            'state'         => $this->city->state->name,
            'location'      => $this->getLocation()
        ];
    }
}
