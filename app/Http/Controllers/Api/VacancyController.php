<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\VacancyResource;
use App\Vacancy;
use Illuminate\Database\Eloquent\Builder;

class VacancyController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $vacancies = Vacancy::orderBy('name');

        
        $cause_id = $request->input('cause_id');
        if(isset($cause_id) && $cause_id !== ''){
            $vacancies = $vacancies->whereHas('causes', function (Builder $query) use ($cause_id) {
                $query->where('id', '=', $cause_id);
            });
        }

        $skill_id = $request->input('skill_id');
        if(isset($skill_id) && $skill_id !== ''){
            $vacancies = $vacancies->whereHas('skills', function (Builder $query) use ($skill_id) {
                $query->where('id', '=', $skill_id);
            });
        }

        $vacancies = $vacancies->orderBy('name', 'asc')->paginate(6);

        return $this->sendResponse(VacancyResource::collection($vacancies));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Vacancy $vacancy)
    {
        return $this->sendResponse(new VacancyResource($vacancy));
    }
}
