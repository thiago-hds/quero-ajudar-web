<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\VolunteerResource;
use App\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VolunteerProfileController extends BaseController
{
    /**
     * 
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserProfile(Request $request)
    {
        $volunteer = Volunteer::find(Auth::user()->id);
        $volunteerResource = new VolunteerResource($volunteer);
        return $this->sendResponse($volunteerResource);
    }
}
