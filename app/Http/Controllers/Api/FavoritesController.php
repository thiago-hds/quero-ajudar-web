<?php

namespace App\Http\Controllers\Api;

use App\Volunteer;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrganizationResource;
use App\Http\Resources\VacancyResource;
use App\Organization;
use App\Vacancy;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class FavoritesController extends BaseController
{

   /**
     * Favorite a vacancy
     *
     * @param  Vacancy  $vacancy
     * @return \Illuminate\Http\Response
     */
    public function saveVacancyAsFavorite(Vacancy $vacancy){
        $user = Auth::user();
        
        try{

            $count = $vacancy->favorites()->where('volunteer_id',$user->id)->count();
            if($count > 0){
                $vacancy->favorites()->where('volunteer_id',$user->id)->delete();
                $response = false;
            }
            else{ 
                $vacancy->favorites()->create([
                    'volunteer_id' => $user->id
                ]);
                $response = true;
            }
        }
        catch(Exception $ex){
            return $this->sendFail('Não foi possível salvar vaga como favorita');
        }
        return $this->sendResponse($response);
    }

/**
     * Favorite a organization
     *
     * @param  Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function saveOrganizationAsFavorite(Organization $organization){
        $user = Auth::user();

        try{
            $count = $organization->favorites()->where('volunteer_id',$user->id)->count();
            if($count > 0){
                $organization->favorites()->where('volunteer_id',$user->id)->delete();
                $response = false;
            }
            else{ 
                $organization->favorites()->create([
                    'volunteer_id' => $user->id
                ]);
                $response = true;
            }
        }
        catch(Exception $ex){
            return $this->sendFail('Não foi possível salvar a organização como favorita');
        }
        return $this->sendResponse($response);
    }

    /**
     * Display a list of vacancies favorited by the authenticated user
     *
     * @return \Illuminate\Http\Response
     */
    public function favoriteVacancies()
    {
        $user_id = Auth::user()->id;        
        $vacancies = Vacancy::whereHas('favorites', function (Builder $query) use ($user_id) {
            $query->where('volunteer_id', '=', $user_id);
        });

        $vacancies = $vacancies->orderBy('name', 'asc')->paginate(10);
        return $this->sendResponse(VacancyResource::collection($vacancies));
    }

    /**
     * Display a list of organizations favorited by the authenticated user
     *
     * @return \Illuminate\Http\Response
     */
    public function favoriteOrganizations()
    {
        $user_id = Auth::user()->id;        
        $organizations = Organization::whereHas('favorites', function (Builder $query) use ($user_id) {
            $query->where('volunteer_id', '=', $user_id);
        });

        $organizations = $organizations->orderBy('name', 'asc')->paginate(10);
        return $this->sendResponse(OrganizationResource::collection($organizations));
    }
}
