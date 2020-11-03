<?php

namespace App\Http\Controllers\Web;

use App\Cause;
use App\Enums\ProfileType;
use App\Skill;
use App\Volunteer;
use App\User;
use App\Http\Requests\Web\VolunteerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class VolunteerController extends Controller
{

    public function __construct()
    {   
        $this->middleware('auth');
        $this->authorizeResource(\App\Volunteer::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // separacao dos campos de filtragem por tipo de comparacao
        $equalFields    =   ['status']; 
        $likeFields     =   ['email'];

        // definir clausulas where
        $whereClauses = [];

        $inputs = $request->all();
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
        
        $volunteers = Volunteer::whereHas('user', function (Builder $query) use ($whereClauses) {
            $query->where($whereClauses);
        });

        if($request->has('name')){
            $name = $request->input('name');
            $volunteers = $volunteers
                ->whereHas('user', function (Builder $query) use ($name) {
                    return $query->whereRaw("CONCAT(first_name, ' ', last_name) like '%{$name}%'");
                });
        }
        
        $cause_id = $request->input('cause_id');
        if(isset($cause_id) && $cause_id !== ''){
            $volunteers = $volunteers->whereHas('causes', function (Builder $query) use ($cause_id) {
                $query->where('id', '=', $cause_id);
            });
        }

        $skill_id = $request->input('skill_id');
        if(isset($skill_id) && $skill_id !== ''){
            $volunteers = $volunteers->whereHas('skills', function (Builder $query) use ($skill_id) {
                $query->where('id', '=', $skill_id);
            });
        }

        // retornar view com dados
        $inputs = (object) $inputs;
        $volunteers = $volunteers->paginate(10);
        $causes = Cause::orderBy('name', 'asc')->get();
        $skills = Skill::orderBy('name', 'asc')->get();

        return view('volunteers.index', compact('inputs', 'volunteers', 'causes', 'skills'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $causes = Cause::orderBy('name', 'asc')->get();
        $skills = Skill::orderBy('name', 'asc')->get();
        return view('volunteers.edit', compact('causes', 'skills'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\VolunteerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VolunteerRequest $request)
    {
        $user = new User([
            'first_name'        => $request->input('first_name'),
            'last_name'         => $request->input('last_name'),
            'date_of_birth'     => $request->input('date_of_birth'),
            'profile'           => ProfileType::VOLUNTEER,
            'email'             => $request->input('email'),
            'password'          => Hash::make($request->input('password')),
            'status'            => $request->input('status')
        ]);
        $user->save();
        
        $volunteer = new Volunteer;
        $volunteer->user()->associate($user);
        $volunteer->save();

        $volunteer->causes()->sync($request->input('causes'));
        $volunteer->skills()->sync($request->input('skills'));

        return redirect('/volunteers')->with('success', 'Voluntário salvo!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Volunteer  $volunteer
     * @return \Illuminate\Http\Response
     */
    public function show($volunteer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Volunteer  $volunteer
     * @return \Illuminate\Http\Response
     */
    public function edit(Volunteer $volunteer)
    {
        $causes = Cause::orderBy('name', 'asc')->get();
        $skills = Skill::orderBy('name', 'asc')->get();
        return view('volunteers.edit', compact('volunteer','causes', 'skills'));   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\VolunteerRequest  $request
     * @param  \App\Volunteer  $volunteer
     * @return \Illuminate\Http\Response
     */
    public function update(VolunteerRequest $request, Volunteer $volunteer)
    {
        $user = User::find($volunteer->user_id);
        $user->update([
            'first_name'        => $request->input('first_name'),
            'last_name'         => $request->input('last_name'),
            'date_of_birth'     => $request->input('date_of_birth'),
            'email'             => $request->input('email'),
            'status'            => $request->input('status')
        ]);

        if($request->input('password') != $user->password){
            $user->password = Hash::make($request->input('password'));
        }

        $volunteer->causes()->sync($request->input('causes'));
        $volunteer->skills()->sync($request->input('skills'));

        return redirect('/volunteers')->with('success', 'Voluntário atualizado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Volunteer  $volunteer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Volunteer $volunteer)
    {
        
        $volunteer->causes()->detach();
        $volunteer->skills()->detach();
        $volunteer->user->delete();
        $volunteer->delete();
        return redirect('/volunteers')->with('success', 'Voluntário excluído!');
    }
}
