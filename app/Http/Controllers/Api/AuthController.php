<?php

namespace App\Http\Controllers\Api;

use App\Enums\ProfileType;
use App\Enums\StatusType;
use App\User;
use App\Volunteer;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Client\Request;

class AuthController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {   
        $input = $request->validated();
        $input['password'] = bcrypt($input['password']);
        $input['profile'] = ProfileType::VOLUNTEER;
        $input['status'] = StatusType::ACTIVE;
        $user = User::create($input);
        
        $volunteer = new Volunteer;
        $volunteer->user()->associate($user);
        $volunteer->save();
    
        $token = $user->createToken('android_app')->plainTextToken;        
        
        Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        $userResource = new UserResource($user);
        $userResource->setToken($token);

        
        return $this->sendResponse($userResource);
    }
   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user();
            $user->tokens()->delete();
            $token = $user->createToken('android_app')->plainTextToken;
            $userResource = new UserResource($user);
            $userResource->setToken($token);
   
            return $this->sendResponse($userResource);
        } 
        else{ 
            return $this->sendFail('E-mail e/ou senha incorretos');
        } 
    }
}
