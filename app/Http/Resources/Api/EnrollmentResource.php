<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class EnrollmentResource extends JsonResource
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
            'id'                    => $this->id,
            'volunteer_user_id'     => $this->volunteer_user_id,
            'vacancy_id'            => $this->vacancy_id,
            'phone'                 => $this->phone->number

        ];
    }
}
