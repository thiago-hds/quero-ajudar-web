<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VolunteerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $userResource = new UserResource($this->user);
        $array = $userResource->toArray(null);
        $array['causes'] = CauseResource::collection($this->causes);
        $array['skills'] = SkillResource::collection($this->skills);
        $array['applications_count'] = $this->applications->count();

        return $array;
    }
}
