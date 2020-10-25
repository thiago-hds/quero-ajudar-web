<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Resources\VacancyResource;
use App\Vacancy;
use App\Favorite;
use App\Volunteer;
use Exception;
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

        $volunteer = Volunteer::find(Auth::user()->id);
        
        $recommendationIds = json_decode($volunteer->getVacancyRecommendations());
        $recommendationsOrdered = implode(',', $recommendationIds);

        $vacancies = Vacancy::whereIn('id', $recommendationIds)
                            ->orderByRaw("FIELD(id, $recommendationsOrdered)");


        $organization_id = $request->input('organization_id');
        if(isset($organization_id) && $organization_id !== ''){
            $vacancies = $vacancies->where('organization_id', $organization_id);
        }

        $causes_id = $request->input('causes_id');
        
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

        $vacancies = $vacancies->paginate(10);
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
        $resource = new VacancyResource($vacancy);
        $resource->setCompleteAddress(true);
        return $this->sendResponse($resource);
    }
}