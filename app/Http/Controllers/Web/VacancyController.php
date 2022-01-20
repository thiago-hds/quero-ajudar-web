<?php

namespace App\Http\Controllers\Web;

use App\City;
use App\Cause;
use App\Skill;
use App\State;
use App\Address;
use App\Enums\LocationType;
use App\Enums\ProfileType;
use App\Enums\RecurrenceType;
use App\Vacancy;
use Carbon\Carbon;
use App\Organization;
use App\Http\Requests\Web\VacancyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use App\Services\ImageUploader;
use App\User;

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
        $filters = $request->all();
        $vacancies = Vacancy::latest()->filter($filters)->paginate(10);

        $organizations  = Organization::orderBy('name', 'asc')->get();
        $causes         = Cause::orderBy('name', 'asc')->get();
        $skills         = Skill::orderBy('name', 'asc')->get();
        $states         = State::orderBy('name', 'asc')->get();

        return view('vacancies.index', compact('vacancies', 'organizations', 'causes', 'skills', 'states'));
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
    public function store(VacancyRequest $request, ImageUploader $imageUploader)
    {

        $attributes = $request->only([
            'name', 'description', 'tasks', 'status', 'type',
            'promotion_start_date', 'promotion_end_date',
            'application_limit', 'location_type'
        ]);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $path = $imageUploader->upload(
                $request->file('image')->getRealPath()
            );
            if ($path) {
                $attributes['image'] = $path;
            }
        }

        $vacancy = new Vacancy($attributes);



        if (!$request->user()->isAdmin()) {
            $organization = Organization::find($request->user()->organization_id);
        } else {
            $organization = Organization::find($request->organization_id);
        }

        if (isset($organization)) {
            $vacancy->organization()->associate($organization);
        }

        // if (
        //     $vacancy->type == RecurrenceType::RECURRENT &&
        //     $request->frequency_negotiable == 'no'
        // ) {
        //         $vacancy->periodicity       = $request->periodicity;
        //         $vacancy->unit_per_period   = $request->unit_per_period;
        //         $vacancy->amount_per_period = $request->amount_per_period;
        // }

        // if (
        //     $vacancy->type == RecurrenceType::UNIQUE_EVENT &&
        //     $request->hours_negotiable == 'no'
        // ) {
        //         $vacancy->date = $request->date;
        //         $vacancy->time = $request->time;
        // } elseif (
        //     $vacancy->type == RecurrenceType::RECURRENT &&
        //     $request->hours_negotiable == 'no'
        // ) {
        //         $vacancy->time = $request->time;
        // }

        $vacancy->save();

        $vacancy->causes()->sync($request->input('causes'));
        $vacancy->skills()->sync($request->input('skills'));

        if ($vacancy->location_type == LocationType::SPECIFIC_ADDRESS) {
            $addressAttributes = $request->only([
                'address_zipcode',
                'address_street',
                'address_number',
                'address_neighborhood',
                'address_city',
            ]);
            $vacancy->address()->create($addressAttributes);
        }

        return redirect('/vacancies')->with('success', 'Vaga salva!');
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
    public function update(VacancyRequest $request, Vacancy $vacancy, ImageUploader $imageUploader)
    {
        $attributes = $request->only([
            'name',
            'description',
            'tasks',
            'status',
            'type',
            'promotion_start_date',
            'promotion_end_date',
            'application_limit',
            'location_type',
        ]);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $path = $imageUploader->upload(
                $request->file('image')->getRealPath()
            );
            if ($path) {
                $attributes['image'] = $path;
            }
        }

        $vacancy->update($attributes);

        if (!$request->user()->isAdmin()) {
            $organization = Organization::find(Auth::user()->organization_id);
        } else {
            $organization = Organization::find($request->organization_id);
        }

        if (isset($organization)) {
            $vacancy->organization()->associate($organization);
        }

        $vacancy->save();

        // LOCAL
        if ($vacancy->location_type == LocationType::SPECIFIC_ADDRESS) {
            $addressAttributes = $request->only([
                'address_zipcode',
                'address_street',
                'address_number',
                'address_neighborhood',
                'address_city',
            ]);
            $vacancy->address()->updateOrCreate($addressAttributes);
        } else {
            $vacancy->address()->delete();
        }

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

    private function saveImage(UploadedFile $file)
    {
        $name = uniqid(date('HisYmd'));
        $extension = $file->extension();
        $nameFile = "{$name}.{$extension}";

        return $file->storeAs('vacancy_image', $nameFile);
    }
}
