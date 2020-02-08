<?php

namespace App\Http\Controllers;

use App\Vacancy;
use App\Volunteer;
use App\Enrollment;
use Illuminate\Http\Request;
use App\Http\Requests\EnrollmentRequest;
use Illuminate\Database\Eloquent\Builder;

class EnrollmentController extends Controller
{

    public function __construct()
    {   
        $this->middleware('auth');
        $this->authorizeResource(\App\Enrollment::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $inputs = $request->all();

        // definir clausulas where
        $whereClauses = [];
        foreach($inputs as $key => $input){
            if($input && in_array($key, ['volunteer_id', 'vacancy_id'])){
                $whereClauses[] = [$key, '=', $input];
            }
        }

        // retornar view com dados
        $inputs = (object) $inputs;
        $enrollments = Enrollment::where($whereClauses)->orderBy('name', 'asc')->paginate(10);
        $vacancies  = Vacancy::orderBy('name')->get();
        $volunteers = Volunteer::orderBy('name')->get();

        return view('enrollments.index', compact('inputs', 'enrollments', 'vacancies', 'volunteers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vacancies = Vacancy::where('status','active')->orderBy('name')->get();
        $volunteers = Volunteer::whereHas('user', function (Builder $query) {
            $query->where('status', 'active');
        })->get();

        return view('enrollments.edit', compact('vacancies', 'volunteers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EnrollmentRequest $request)
    {
        $enrollment = new Enrollment;
        $enrollment->vacancy()->associate(Vacancy::find($request->input('vacancy_id')));
        $enrollment->volunteer()->associate(Volunteer::find($request->input('volunteer_id')));
        $enrollment->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Enrollment  $enrollment
     * @return \Illuminate\Http\Response
     */
    public function destroy($enrollment)
    {
        $enrollment->delete();
    }
}
