<?php

namespace App\Http\Controllers\Web;

use App\Organization;
use App\OrganizationType;
use App\Phone;
use App\State;
use App\Http\Requests\Web\OrganizationRequest;
use App\Http\Controllers\Controller;
use App\Services\ImageUploader;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filters = request(['name', 'email', 'status', 'cause_id']);
        $organizations = Organization::latest()->filter($filters)->paginate(10);

        return view('organizations.index', compact('organizations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $organizationTypes = OrganizationType::orderBy('name', 'asc')->get();
        $states = State::orderBy('name', 'asc')->get();

        return view('organizations.edit', compact('organizationTypes', 'states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\OrganizationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrganizationRequest $request, ImageUploader $imageUploader)
    {

        $organizationAttributes = request()->only([
            'name',
            'website',
            'description',
            'email',
            'status',
            'organization_type_id'
        ]);

        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            $path = $imageUploader->upload(
                $request->file('logo')->getRealPath()
            );
            if ($path) {
                $organizationAttributes['logo'] = $path;
            }
        }

        $organization = Organization::create($organizationAttributes);
        $organization->causes()->sync($request->causes);

        $addressAttributes = [
            'zipcode' => $request->address_zipcode ,
            'street' => $request->address_street ,
            'number' => $request->address_number ,
            'neighborhood' => $request->address_neighborhood ,
            'city_id' => $request->address_city
        ];
        $organization->address()->create($addressAttributes);

        foreach ($request->input('phones') as $number) {
            $number = preg_replace('/[() ]/', '', $number);
            $organization->phones()->save(new Phone(['number' => $number]));
        }

        return redirect('/organizations')->with('success', 'Instituição Salva!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Organization $organization
     * @return \Illuminate\Http\Response
     */
    public function edit(Organization $organization)
    {
        $organizationTypes = OrganizationType::orderBy('name', 'asc')->get();
        $states = State::orderBy('name', 'asc')->get();
        return view('organizations.edit', compact('organizationTypes', 'organization', 'states'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\OrganizationRequest $request
     * @param  \App\Organization                      $organization
     * @return \Illuminate\Http\Response
     */
    public function update(OrganizationRequest $request, Organization $organization, ImageUploader $imageUploader)
    {

        $organizationAttributes = request()->only([
            'name',
            'website',
            'description',
            'email',
            'status',
            'organization_type_id'
        ]);

        if (request()->hasFile('logo')) {
            try {
                $path = $imageUploader->upload(
                    request()->file('logo')->getRealPath()
                );
                $organizationAttributes['logo'] = $path;
            } catch (\Exception $ex) {
                return response()->with('error', 'Não foi possível fazer upload da imagem');
            }
        }

        $organization->update($organizationAttributes);
        $organization->causes()->sync($request->input('causes'));

        // save organization addresses

        $addressAttributes = request()->only([
            'address_zipcode',
            'address_street',
            'address_number',
            'address_neighborhood',
            'address_city'
        ]);
        $organization->address()->updateOrCreate($addressAttributes);

        // save organization phones

        $organization->phones()->delete();
        foreach ($request->input('phones') as $number) {
            $number = preg_replace('/[() ]/', '', $number);
            $organization->phones()->create([
                'number' => $number
            ]);
        }

        return redirect('/organizations')
            ->with('success', 'Instituição atualizada!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Organization $organization
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organization $organization)
    {
        $organization->delete();
        return redirect('/organizations')->with('success', 'Instituição excluída!');
    }
}
