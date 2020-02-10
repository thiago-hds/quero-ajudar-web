<?php

namespace App\Http\Controllers\Api;

use App\User;
use Validator;
use App\Volunteer;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;

class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name'              => 'required',
            'date_of_birth'     =>  'required|date_format:d/m/Y|before:today',
            'email'             => 'required|email|unique:users,email',
            'password'          => 'required',
            'password_confirm'  => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['profile'] = User::VOLUNTEER;
        $user = User::create($input);
        
        $volunteer = new Volunteer;
        $volunteer->user()->associate($user);
        $volunteer->save();

        $success['token'] =  $user->createToken('QueroAjudar')->accessToken;
        $success['name'] =  $user->name;
   
        return $this->sendResponse($success, 'User register successfully.');
    }
   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            $success['name'] =  $user->name;
   
            return $this->sendResponse($success, 'User login successfully.');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }
}
