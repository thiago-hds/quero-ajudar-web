<?php

namespace App\Http\Controllers\Api;



use App\Cause;
use App\Http\Resources\CauseResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateCausesRequest;
use App\Volunteer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CauseController extends BaseController
{

    public function __construct()
    {
        //$this->middleware('auth:airlock');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->sendResponse(CauseResource::collection(Cause::all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  Cause  $cause
     * @return \Illuminate\Http\Response
     */
    public function show(Cause $cause)
    {
        return $this->sendResponse(new CauseResource($cause));
    }

    /**
     * Update user causes
     *
     * @param  UpdateCausesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function updateUserCauses(UpdateCausesRequest $request){

        try{
            $volunteer = Volunteer::find(Auth::user()->id);
            $volunteer->causes()->sync($request->causes_ids);
            $response = true;
        }
        catch(Exception $ex){
            return $this->sendFail('Não foi possível atualizar causas');
        }

        return $this->sendResponse($response);
    }

}
