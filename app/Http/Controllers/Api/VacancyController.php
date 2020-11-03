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
        $vacancies = Vacancy::orderBy('name');

        $organization_id = $request->input('organization_id');
        if(isset($organization_id) && $organization_id !== ''){
            $vacancies = $vacancies->where('organization_id', $organization_id);
        }

        $causes_id = $request->input('causes_id');
        
        if(isset($causes_id) && $causes_id !== ''){
            $causes_id = explode(',',$causes_id);
            $vacancies = $vacancies->whereHas('causes',
                function (Builder $query) use ($causes_id) {
                    $query->whereIn('id', $causes_id);
                }
            );
        }

        $skills_id = $request->input('skills_id');
        if(isset($skills_id) && $skills_id !== ''){
            $skills_id = explode(',',$skills_id);
            $vacancies = $vacancies->whereHas('skills',
                function (Builder $query) use ($skills_id) {
                    $query->whereIn('id', $skills_id);
                }
            );
        }

        $vacancies = $vacancies->orderBy('name', 'asc')->paginate(10);
        return $this->sendResponse(VacancyResource::collection($vacancies));
    }

    public function vacancyRecommendations(Request $request)
    {

        $volunteer = Volunteer::find(Auth::user()->id);
        $causes_id = $request->input('causes_id');
        $skills_id = $request->input('skills_id');
        
        // se o usuario ja tiver inscrições, usar sistema de recomendação
        if($volunteer->applications()->count() > 0){
            if($volunteer->recommendations === null){
                $recommendations = $volunteer->getVacancyRecommendations();
                $volunteer->recommendations = $recommendations;
                $volunteer->save();
            }

            $recommendationIds = json_decode($volunteer->recommendations);
            
            $recommendationsOrdered = implode(',', $recommendationIds);

            $vacancies = Vacancy::whereIn('id', $recommendationIds)
                                ->orderByRaw("FIELD(id, $recommendationsOrdered)");
        }

        //caso contrário, filtrar por causas selecionadas
        else{
            $vacancies = Vacancy::where('status', 1)->inRandomOrder();
            
            if(isset($causes_id) && $causes_id !== ''){
                $causes_id = $volunteer->causes()->pluck('id');
            }
            if(isset($skills_id) && $skills_id !== ''){
                $skills_id = $volunteer->skills()->pluck('id');
            }
        }

        $organization_id = $request->input('organization_id');
        if(isset($organization_id) && $organization_id !== ''){
            $vacancies = $vacancies->where('organization_id', $organization_id);
        }

        if(isset($causes_id) && $causes_id !== ''){
            $causes_id = explode(',',$causes_id);
            $vacancies = $vacancies->whereHas('causes',
                function (Builder $query) use ($causes_id) {
                    $query->whereIn('id', $causes_id);
                }
            );
        }


        if(isset($skills_id) && $skills_id !== ''){
            $skills_id = explode(',',$skills_id);
            $vacancies = $vacancies->whereHas('skills',
                function (Builder $query) use ($skills_id) {
                    $query->whereIn('id', $skills_id);
                }
            );
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