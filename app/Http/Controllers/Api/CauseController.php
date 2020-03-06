<?php

namespace App\Http\Controllers\Api;

use App\Cause;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CauseResource;

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Cause $cause)
    {
        return $this->sendResponse(new CauseResource($cause));
    }

}
