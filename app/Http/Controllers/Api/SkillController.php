<?php

namespace App\Http\Controllers\Api;

use App\Skill;
use App\Http\Resources\SkillResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SkillController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->sendResponse(SkillResource::collection(Skill::all()));
    }

 

    /**
     * Display the specified resource.
     *
     * @param  Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function show($skill)
    {
        return $this->sendResponse(new SkillResource($skill));
    }
}
