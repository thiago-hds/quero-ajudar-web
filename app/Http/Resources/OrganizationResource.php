<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class OrganizationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $array =  [
            'id'                    => $this->id,
            'name'                  => $this->name,
            'logo'                  => $this->logo? Storage::url($this->logo) : null,
            'causes'                => CauseResource::collection($this->causes),
            'description'           => $this->description,
            'email'                 => $this->email,
            'website'               => $this->website,
            'phones'                => $this->phones->pluck('number')->all(),
            'formatted_location'    => $this->address->getFormattedAddress()
        ];

        if($user = Auth::user()){
            $count = $this->favorites()->where('volunteer_id',$user->id)->count();
            $array['favourited'] = $count > 0? true : false;
        }

        return $array;
    }
}
