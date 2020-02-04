<?php

namespace App\Http\Controllers;

use App\City;
use App\Cause;
use App\Skill;
use App\State;
use App\Address;
use App\Vacancy;
use App\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\VacancyRequest;

class VacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $organizations = Organization::orderBy('name', 'asc')->get();
        $causes = Cause::orderBy('name', 'asc')->get();
        $skills = Skill::orderBy('name', 'asc')->get();

        $states = State::orderBy('name', 'asc')->get();

        return view('vacancies.edit', compact('organizations', 'causes', 'skills', 'states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\VacancyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VacancyRequest $request)
    {
        $vacancy = new Vacancy([
            'name'                  => $request->input('name'),
            'description'           => $request->input('description'),
            'tasks'                 => $request->input('tasks'),
            'status'                => $request->input('status'),
            'type'                  => $request->input('type'),
            'promotion_start_date'  => $request->input('promotion_start_date'),
            'promotion_end_date'    => $request->input('promotion_end_date'),
            'enrollment_limit'      => $request->input('enrollment_limit'),
        ]);
        $vacancy->save();

        $address = new Address([
            'zipcode'           => $request->input('zipcode'),
            'street'            => $request->input('street'),
            'number'            => $request->input('number'),
            'neighborhood'      => $request->input('neighborhood'),
            'state'             => $request->input('state'),
            'city'              => $request->input('city'),
        ]);
        $address->save();

        $vacancy->address()->associate($address);
        $vacancy->causes()->sync($request->input('causes'));
        $vacancy->skills()->sync($request->input('skills'));
        

        if(!Auth::user()->isAdmin()){
            $organization = Organization::find(Auth::user()->organization_id);
        }
        else{
            $organization = Organization::find($request->input('organization_id'));
        }

        if(isset($organization)){
            $vacancy->organization()->associate($organization);
        }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\VacancyRequest  $request
     * @param  \App\Vacancy  $vacancy
     * @return \Illuminate\Http\Response
     */
    public function update(VacancyRequest $request, Vacancy $vacancy)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vacancy  $vacancy
     * @return \Illuminate\Http\Response
     */
    public function destroy($vacancy)
    {
        //
    }
}
