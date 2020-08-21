<?php

namespace App\Http\Controllers\Api;

use App\Skill;
use App\Http\Resources\SkillResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateSkillsRequest;
use App\Volunteer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

/**
     * Update user causes
     *
     * @param  UpdateSkillsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function updateUserSkills(UpdateSkillsRequest $request){

        try{
            $volunteer = Volunteer::find(Auth::user()->id);
            $volunteer->skills()->sync($request->skills_ids);
            $response = true;
        }
        catch(Exception $ex){
            return $this->sendFail('Não foi possível atualizar habilidades');
        }

        return $this->sendResponse($response);
    }
}
