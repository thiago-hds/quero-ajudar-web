<?php

namespace App\Http\Controllers\Api;

use App\Organization;
use App\Http\Resources\OrganizationResource;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->sendResponse(
            OrganizationResource::collection(Organization::all())
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function show(Organization $organization)
    {
        return $this->sendResponse(new OrganizationResource($organization));
    }
    /**
     * Favorite a organization
     *
     * @param  Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function favorite(Organization $organization){
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

}
