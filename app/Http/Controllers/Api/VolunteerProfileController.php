<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
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
        $user = Auth::user();
        $userResource = new UserResource($user);
        return $this->sendResponse($userResource);
    }
}
