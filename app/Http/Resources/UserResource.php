<?php

namespace App\Http\Resources;

use App\Enums\StatusType;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserResource extends JsonResource
{

    protected $token;

    public function setToken($value){
        $this->token = $value;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $array = [
            'id'                        => $this->id,
            'first_name'                => $this->first_name,
            'last_name'                 => $this->last_name,
            'email'                     => $this->email,
            'date_of_birth'             => $this->date_of_birth,
            'status'                    => $this->status,
	    'application_count'		=> 0	
        ];

        if(isset($this->token) && Auth::user()->id == $this->id){
            $array['token'] = $this->token;
        }
        return $array;
    }
}
