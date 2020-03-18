<?php

namespace App\Http\Controllers\Api;



use App\Cause;
use App\Http\Resources\CauseResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


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

}
