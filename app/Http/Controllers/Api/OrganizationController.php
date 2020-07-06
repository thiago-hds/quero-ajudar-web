<?php

namespace App\Http\Controllers\Api;

use App\Organization;
use App\Http\Resources\OrganizationResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

    public function favorite(Organization $organization){
        $user = Auth::user();
        $organization->favorites()->create([
            'user_id' => $user->id
        ]);
    }

}
