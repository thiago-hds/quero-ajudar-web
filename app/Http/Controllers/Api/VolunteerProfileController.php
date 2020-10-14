<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\EditProfileRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\VolunteerResource;
use App\Volunteer;
use Illuminate\Support\Facades\Auth;

class VolunteerProfileController extends BaseController
{
    /**
     * 
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserProfile()
    {
        $volunteer = Volunteer::find(Auth::user()->id);
        $volunteerResource = new VolunteerResource($volunteer);
        return $this->sendResponse($volunteerResource);
    }

    public function editUserProfile(EditProfileRequest $request){
        $volunteer = Volunteer::find(Auth::user()->id);
        $user = $volunteer->user;
        
        $input = $request->validated();
        $user->first_name = $input['first_name'];
        $user->last_name = $input['last_name'];
        $user->email = $input['email'];

        if($request->has('password')){
            $user->password = bcrypt($input['password']);
        }
        $user->save();
        return $this->sendResponse(new UserResource($user));
    }

}
