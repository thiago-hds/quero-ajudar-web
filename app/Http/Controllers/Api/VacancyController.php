<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Resources\VacancyResource;
use App\Vacancy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

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

        
        $causes_id = $request->input('causes_id');
        //$causes_id = "9"; //test
        if(isset($causes_id) && $causes_id !== ''){
            $causes_id = explode(',',$causes_id);
            $vacancies = $vacancies->whereHas('causes', function (Builder $query) use ($causes_id) {
                $query->whereIn('id', $causes_id);
            });
        }

        $skills_id = $request->input('skills_id');
        if(isset($skills_id) && $skills_id !== ''){
            $skills_id = explode(',',$skills_id);
            $vacancies = $vacancies->whereHas('skills', function (Builder $query) use ($skills_id) {
                $query->whereIn('id', $skills_id);
            });
        }

        $vacancies = $vacancies->orderBy('name', 'asc')->paginate(10);
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

    public function favorite(Vacancy $vacancy){
        $user = Auth::user();
        $vacancy->favorites()->create([
            'user_id' => $user->id
        ]);
    }
}
