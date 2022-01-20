<?php

namespace App\Http\Controllers\Web;

use App\Vacancy;
use App\Volunteer;
use App\Application;
use App\Enums\StatusType;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationRequest;
use App\Http\Requests\Web\ApplicationRequest as WebApplicationRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ApplicationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(\App\Application::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inputs = $request->all();

        $whereClauses = [];
        foreach ($inputs as $key => $input) {
            if ($input && in_array($key, ['volunteer_user_id', 'vacancy_id'])) {
                $whereClauses[] = [$key, '=', $input];
            }
        }

        // retornar view com dados
        $applications = Application::where($whereClauses)->paginate(10);
        $vacancies  = Vacancy::orderBy('name')->get();
        $volunteers = Volunteer::all();

        return view('applications.index', compact('applications', 'vacancies', 'volunteers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vacancies = Vacancy::where('status', StatusType::ACTIVE)->orderBy('name')->get();
        $volunteers = Volunteer::whereHas('user', function (Builder $query) {
            $query->where('status', StatusType::ACTIVE);
        })->get();

        return view('applications.edit', compact('vacancies', 'volunteers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WebApplicationRequest $request)
    {
        $volunteer = Volunteer::find($request->input('volunteer_user_id'));

        $application = new Application();
        $application->vacancy()->associate(Vacancy::find($request->input('vacancy_id')));
        $application->volunteer()->associate($volunteer);
        $application->save();

        $volunteer->updateRecommendations();

        return redirect('/applications')->with('success', 'Inscrição salva!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy($application)
    {
        $application->delete();
    }
}
