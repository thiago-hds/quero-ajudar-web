<?php

namespace App\Http\Controllers;

use App\Organization;
use App\OrganizationType;
use App\Cause;
use App\Phone;
use App\Http\Requests\OrganizationRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

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
        $equalFields    =   ['status']; 
        $likeFields     =   ['name', 'email'];

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

        $organizations = Organization::where($whereClauses);

        $cause_id = $request->input('cause_id');
        if(isset($cause_id) && $cause_id !== ''){
            $organizations = $organizations->whereHas('causes', function (Builder $query) use ($cause_id) {
                $query->where('id', '=', $cause_id);
            });
        }

        // retornar view com dados
        $inputs = (object) $inputs;
        $organizations = $organizations->orderBy('name', 'asc')->paginate(10);
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
            'website'           => $request->input('website'),
            'description'       => $request->input('description'),
            'email'             => $request->input('email'),
            'status'            => $request->input('status')
        ]);
        
        if($request->hasFile('logo') && $request->file('logo')->isValid()){

            $name = uniqid(date('HisYmd'));
            $extension = $request->file('logo')->extension();
            $nameFile = "{$name}.{$extension}";

            $upload = $request->file('logo')->storeAs('logo', $nameFile);
            
            if($upload){
                $organization->logo = $upload;
            }
            else{

            }
        }

        $organization->organizationType()->associate($request->input('organization_type_id'));
        $organization->save();

        $organization->causes()->sync($request->input('causes'));

        foreach($request->input('phones') as $number){
            $number = preg_replace('/[() ]/', '', $number);
            $organization->phones()->save(new Phone(['number' => $number]));
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
     * @param  \App\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function edit(Organization $organization)
    {
        $organizationTypes = OrganizationType::orderBy('name', 'asc')->get();
        $causes = Cause::orderBy('name', 'asc')->get();
        return view('organizations.edit', compact('organizationTypes','causes','organization')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\OrganizationRequest  $request
     * @param  \App\Organization $organization
     * @return \Illuminate\Http\Response
     */
    public function update(OrganizationRequest $request, Organization $organization)
    {
        $organization->update([
            'name'              => $request->input('name'),
            'website'           => $request->input('website'),
            'description'       => $request->input('description'),
            'email'             => $request->input('email'),
            'status'            => $request->input('status')
        ]);

        $organization->organizationType()->associate($request->input('organization_type_id'));
        $organization->causes()->sync($request->input('causes'));
        
        $organization->phones()->delete();
        foreach($request->input('phones') as $number){
            $number = preg_replace('/[() ]/', '', $number);
            $organization->phones()->create([
                'number' => $number
            ]);
        }

        return redirect('/organizations')->with('success', 'Instituição atualizada!');

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
