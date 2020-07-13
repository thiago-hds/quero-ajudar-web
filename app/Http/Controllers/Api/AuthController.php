<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Volunteer;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Resources\UserResource;

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
        $input['profile'] = User::VOLUNTEER;
        $user = User::create($input);
        
        $volunteer = new Volunteer;
        $volunteer->user()->associate($user);
        $volunteer->save();
    
        $user->createToken('android_app')->plainTextToken;        
   
        return $this->sendResponse(new UserResource($user));
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
