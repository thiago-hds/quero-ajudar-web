<?php

namespace App\Http\Controllers;

use App\Organization;
use App\OrganizationType;
use App\Cause;
use App\Http\Requests\OrganizationRequest;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{

    public function __construct()
    {   
        $this->middleware('auth');
        $this->authorizeResource(\App\Organization::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // separacao dos campos de filtragem por tipo de comparacao
        $equalFields    =   ['profile', 'organization_id', 'status']; 
        $likeFields     =   ['name', 'email'];

        $inputs = $request->all();

        // definir clausulas where
        $whereClauses = [];

        //if(Auth::user()->profile == User::ORGANIZATION){
        //    $inputs['organization_id'] = Auth::user()->organization_id;
        //}

        foreach($inputs as $key => $input){
            if($input && in_array($key, array_merge($equalFields, $likeFields))){
                if(in_array($key,['profile','organization_id','status'])){
                    $whereClauses[] = [$key, '=', $input];
                }
                else{
                    $whereClauses[] = [$key, 'like', '%'.$input.'%'];
                }
            }
        }

        // retornar view com dados
        $inputs = (object) $inputs;
        $organizations = Organization::where($whereClauses)->orderBy('name', 'asc')->paginate(10);
        $causes = Cause::orderBy('name', 'asc')->get();

        return view('organizations.index', compact('inputs', 'organizations', 'causes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $organizationTypes = OrganizationType::orderBy('name', 'asc')->get();
        $causes = Cause::orderBy('name', 'asc')->get();
        return view('organizations.edit', compact('organizationTypes','causes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\OrganizationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrganizationRequest $request)
    {
        $organization = new Organization([
            'name'              => $request->input('name'),
            'website'           => $request->input('website')? $request->input('website') : '',
            'description'       => $request->input('description'),
            'logo'              => '',
            'email'             => $request->input('email'),
            'status'            => $request->input('status')
        ]);

        $organization->organizationType()->associate($request->input('organization_type_id'));
        $organization->save();

        $organization->causes()->attach($request->input('causes'));

        foreach($request->input('phones') as $number){
            $organization->phones()->create([
                'number' => $number
            ]);
        }

        return redirect('/organizations')->with('success', 'Instituição Salva!');
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
