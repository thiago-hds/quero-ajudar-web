<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Volunteer;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;

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
    
        $user['token'] =  $user->createToken('QueroAjudar')->accessToken;
        $data['user'] = $user;
   
        return $this->sendResponse($data);
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
            $user['token'] =  $user->createToken('QueroAjudar')->accessToken;

            $data['user'] = $user;

   
            return $this->sendResponse($data);
        } 
        else{ 
            return $this->sendFail('E-mail e/ou senha incorretos');
        } 
    }
}
