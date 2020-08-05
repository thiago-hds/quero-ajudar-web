<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CauseResource extends JsonResource
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
            'id'                        => $this->id,
            'name'                      => $this->name,
            'fontawesome_icon_unicode'  => sprintf('&#x%s;',$this->fontawesome_icon_unicode)
        ];
    }
}
