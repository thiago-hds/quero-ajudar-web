<?php

namespace App\Http\Controllers\Web;

use App\Organization;
use App\OrganizationType;
use App\Cause;
use App\Phone;
use App\State;
use App\Http\Requests\Web\OrganizationRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;

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

        foreach ($inputs as $key => $input) {
            if ($input && in_array($key, array_merge($equalFields, $likeFields))) {
                if (in_array($key, $equalFields)) {
                    $whereClauses[] = [$key, '=', $input];
                } else {
                    $whereClauses[] = [$key, 'like', '%' . $input . '%'];
                }
            }
        }

        $organizations = Organization::where($whereClauses);

        $cause_id = $request->input('cause_id');
        if (isset($cause_id) && $cause_id !== '') {
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
        $states = State::orderBy('name', 'asc')->get();

        return view('organizations.edit', compact('organizationTypes', 'causes', 'states'));
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

        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            $path = $this->saveImage($request->file('logo'));
            if ($path) {
                $organization->logo = $path;
            }
        }

        $organization->organizationType()->associate($request->input('organization_type_id'));
        $organization->save();

        $organization->causes()->sync($request->input('causes'));


        $organization->address()->create([
            'zipcode'           => $request->input('address_zipcode'),
            'street'            => $request->input('address_street'),
            'number'            => $request->input('address_number'),
            'neighborhood'      => $request->input('address_neighborhood'),
            'city_id'           => $request->input('address_city'),
        ]);

        foreach ($request->input('phones') as $number) {
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
        $states = State::orderBy('name', 'asc')->get();
        return view('organizations.edit', compact('organizationTypes', 'causes', 'organization', 'states'));
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

        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            $path = $this->saveImage($request->file('logo'));
            if ($path) {
                $organization->logo = $path;
                $organization->save();
            }
        }

        $organization->organizationType()->associate($request->input('organization_type_id'));
        $organization->causes()->sync($request->input('causes'));

        $organization->address()->updateOrCreate([
            'zipcode'           => $request->input('address_zipcode'),
            'street'            => $request->input('address_street'),
            'number'            => $request->input('address_number'),
            'neighborhood'      => $request->input('address_neighborhood'),
            'city_id'           => $request->input('address_city'),
        ]);

        $organization->phones()->delete();
        foreach ($request->input('phones') as $number) {
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
     * @param  \App\Organization $organization
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organization $organization)
    {
        $organization->delete();
        return redirect('/organization')->with('success', 'Instituição excluída!');
    }

    private function saveImage(UploadedFile $file)
    {
        $name = uniqid(date('HisYmd'));
        $extension = $file->extension();
        $nameFile = "{$name}.{$extension}";

        return $file->storeAs('vacancy_image', $nameFile);
    }
}
