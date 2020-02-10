<?php

namespace App\Http\Controllers\Web;

use App\City;
use App\Cause;
use App\Skill;
use App\State;
use App\Address;
use App\Vacancy;
use Carbon\Carbon;
use App\Organization;
use App\Http\Requests\VacancyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;


class VacancyController extends Controller
{

    public function __construct()
    {   
        $this->middleware('auth');
        $this->authorizeResource(\App\Vacancy::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // separacao dos campos de filtragem por tipo de comparacao
        $equalFields    =   ['status','type']; 
        $likeFields     =   ['name'];

        $inputs = $request->all();
        
        // definir clausulas where
        $whereClauses = []; 
        
        foreach($inputs as $key => $input){
            if($input && in_array($key, array_merge($equalFields, $likeFields))){
                if(in_array($key,$equalFields)){
                    $whereClauses[] = [$key, '=', $input];
                }
                else{
                    $whereClauses[] = [$key, 'like', '%'.$input.'%'];
                }
            }
        }

        $vacancies = Vacancy::where($whereClauses);

        
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
        
        
        $state_abbr = $request->input('address_state');
        if(isset($state_abbr) && $state_abbr !== ''){
            $vacancies = $vacancies->whereHas('address.city.state', function (Builder $query) use ($state_abbr) {
                $query->where('abbr', '=', $state_abbr);
            }); 
        }
        
        $city_id = $request->input('address_city');
        if(isset($city_id) && $city_id !== '0'){
            $vacancies = $vacancies->whereHas('address.city', function (Builder $query) use ($city_id) {
                $query->where('id', '=', $city_id);
            }); 
        }
       

        // retornar view com dados
        $inputs = (object) $inputs;
        $vacancies      = $vacancies->orderBy('name', 'asc')->paginate(10);
        $organizations  = Organization::orderBy('name', 'asc')->get();
        $causes         = Cause::orderBy('name', 'asc')->get();
        $skills         = Skill::orderBy('name', 'asc')->get();
        $states         = State::orderBy('name', 'asc')->get();

        return view('vacancies.index', compact('inputs', 'vacancies', 'organizations', 'causes', 'skills', 'states'));
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

        if($vacancy->type == Vacancy::UNIQUE_EVENT){
            $vacancy->time = sprintf('%s %s', $request->input('date'), $request->input('hour'));
        }

        if(!Auth::user()->isAdmin()){
            $organization = Organization::find(Auth::user()->organization_id);
        }
        else{
            $organization = Organization::find($request->input('organization_id'));
        }

        if(isset($organization)){
            $vacancy->organization()->associate($organization);
        }   

        $vacancy->save();

        $vacancy->address()->create([
            'zipcode'           => $request->input('address_zipcode'),
            'street'            => $request->input('address_street'),
            'number'            => $request->input('address_number'),
            'neighborhood'      => $request->input('address_neighborhood'),
            'city_id'           => $request->input('address_city'),
        ]);

        $vacancy->causes()->sync($request->input('causes'));
        $vacancy->skills()->sync($request->input('skills'));
        
        return redirect('/vacancies')->with('success', 'Vaga salva!');
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
     * @param  \App\Vacancy  $vacancy
     * @return \Illuminate\Http\Response
     */
    public function edit(Vacancy $vacancy)
    {
        $organizations = Organization::orderBy('name', 'asc')->get();
        $causes = Cause::orderBy('name', 'asc')->get();
        $skills = Skill::orderBy('name', 'asc')->get();
        $states = State::orderBy('name', 'asc')->get();

        return view('vacancies.edit', compact('vacancy', 'organizations', 'causes', 'skills', 'states'));
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
        $vacancy->update([
            'name'                  => $request->input('name'),
            'description'           => $request->input('description'),
            'tasks'                 => $request->input('tasks'),
            'status'                => $request->input('status'),
            'type'                  => $request->input('type'),
            'promotion_start_date'  => $request->input('promotion_start_date'),
            'promotion_end_date'    => $request->input('promotion_end_date'),
            'enrollment_limit'      => $request->input('enrollment_limit'),
            'time'                  => $request->input('type') == Vacancy::UNIQUE_EVENT? sprintf('%s %s', $request->input('date'), $request->input('hour')) : null,
        ]);

        if(!Auth::user()->isAdmin()){
            $organization = Organization::find(Auth::user()->organization_id);
        }
        else{
            $organization = Organization::find($request->input('organization_id'));
        }

        if(isset($organization)){
            $vacancy->organization()->associate($organization);
        }   

        $vacancy->save();

        $vacancy->address()->update([
            'zipcode'           => $request->input('address_zipcode'),
            'street'            => $request->input('address_street'),
            'number'            => $request->input('address_number'),
            'neighborhood'      => $request->input('address_neighborhood'),
            'city_id'           => $request->input('address_city'),
        ]);

        $vacancy->causes()->sync($request->input('causes'));
        $vacancy->skills()->sync($request->input('skills'));
        
        return redirect('/vacancies')->with('success', 'Vaga atualizada!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vacancy  $vacancy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vacancy $vacancy)
    {
        $vacancy->delete();
        return redirect('/vacancies')->with('success', 'Vaga excluída!');
    }
}
